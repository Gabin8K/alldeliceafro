<?php

namespace App\Http\Controllers\Partner;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRegisterRequest;
use App\Mail\SendPasswordResetLinkMail;
use App\Models\User;
use App\Services\PasswordService;
use App\Services\UserService;
use App\Services\VerificationCodeService;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Partner/Welcome', [
            'canLogin' => Route::has('partner.login'),
            'canRegister' => Route::has('partner.register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Partner/Auth/Register');
    }

    public function store(PartnerRegisterRequest $request): RedirectResponse
    {
        $role = RolesEnum::from($request->partner_type);
        $user = UserService::store($request, $role);

        UserService::sendVerificationEmail($user);

        $clasName = $role->className();
        $partner = new $clasName();
        $partner->query()->create([
            'user_id' => $user->id,
            'name' => $request->partner_name,
        ]);

        return Redirect::route('partner.verify.email', [$request->language, $user->id]);
    }

    public function login(): Response
    {
        return Inertia::render('Partner/Auth/Login', [
            'status' => session('status'),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        /**
         * @todo Get Role list from RoleEnum Trait
         */
        if ($user && Hash::check($request->password, $user->password) && $user->hasRole([RolesEnum::RESTAURANT, RolesEnum::STORE])) {
            if ($user->email_verified_at == null) {
                UserService::sendVerificationEmail($user);
                return Redirect::route('partner.verify.email', [$request->language, $user->id]);
            }

            Auth::login($user);

            return Redirect::route($user->getRoleNames()->first() . '.dashboard', $request->language);
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    public function verifyEmail(Request $request): Response|RedirectResponse
    {
        $user = User::find($request->user_id);

        if ($user && isset($user->email_verified_at)) {
            return Redirect::route('partner.login', $request->language);
        }

        return Inertia::render('Partner/Auth/VerifyEmail', [
            'user_id' => $request->user_id,
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function verifyEmailStore(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required',
            'verification_code' => 'required|numeric|digits:4',
        ]);

        $is_valid = VerificationCodeService::checkAndDeleteUserVerificationCode($request->user_id, $request->verification_code);

        if (!$is_valid) {
            throw ValidationException::withMessages([
                'verification_code' => trans('Verification code invalid'),
            ]);
        }

        $user = User::find($request->user_id);
        $user->markEmailAsVerified();

        Auth::login($user);

        return Redirect::route($user->getRoleNames()->first() . '.dashboard', $request->language);
    }

    public function verifyEmailRequest(Request $request): RedirectResponse
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return Redirect::back()->with('error', 'User not found');
        }

        UserService::sendVerificationEmail($user);

        return Redirect::back()->with('success', 'We have send you the new verification code');
    }

    public function forgotPassword(): Response
    {
        return Inertia::render('Partner/Auth/ForgotPassword', [
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    public function forgotPasswordStore(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = PasswordService::genrateResetToken($request->email);
        $link = route('partner.password.reset', [$request->language, $token]) . '?email=' . urlencode($request->email);
        Mail::to($request->email)->send(new SendPasswordResetLinkMail($request->email, $token, $link));

        return Redirect::back()->with('success', 'Reset-link send, please check your email');
    }

    public function resetPassword(Request $request): Response|RedirectResponse
    {
        $token_is_valid = PasswordService::checkResetTokenValidity($request->email, $request->route('token'));

        if (!$token_is_valid) {
            return Redirect::route('partner.password.request', $request->language)->with('error', 'Reset-link invalid, please request a new one.');
        }

        return Inertia::render('Partner/Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token')
        ]);
    }

    public function resetPasswordStore(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $token_is_valid = PasswordService::checkAndDeleteResetToken($request->email, $request->token);

        if (!$token_is_valid) {
            return Redirect::route('partner.password.request', $request->language)->with('error', 'Reset-link invalid, please request a new one.');
        }

        $user = User::query()->where('email', $request->email)->first();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return Redirect::route('partner.login', $request->language)->with('status', 'success');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::route('partner.index', $request->language);
    }
}
