<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Mail\SendPasswordResetLinkMail;
use App\Mail\SendVerificationCodeMail;
use App\Models\User;
use App\Services\PasswordService;
use App\Services\UserService;
use App\Services\VerificationCodeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function getUser(Request $request): Response
    {
        return \response([
            'success' => true,
            'user' => new UserResource($request->user())
        ], 200);
    }

    public function authenticate(LoginRequest $request): Response
    {
        $user = User::query()
            ->where('email', $request->get('email'))
            ->first();

        if ($user && Hash::check($request->get('password'), $user->password)) {
            return \response([
                'success' => true,
                'token' => $user->createToken(time())->plainTextToken
            ], 200);
        }

        return \response([
            'success' => false,
            'message' => 'These credentials do not match our records.'
        ], 401);
    }

    public function register(RegisterRequest $request): Response
    {
        $user = UserService::store($request, RolesEnum::USER);
        UserService::sendVerificationEmail($user);

        return \response([
            'success' => true,
            'token' => $user->createToken(time())->plainTextToken
        ], 200);
    }

    public function requestVerificationCode(Request $request): Response
    {
        if (isset($request->user()->email_verified_at)) {
            return \response([
                'success' => false,
                'message' => 'You have already verify your email',
            ], 401);
        }

        UserService::sendVerificationEmail($request->user());

        return \response([
            'success' => true
        ], 200);
    }

    public function verify(Request $request): Response
    {
        $request->validate([
            'verification_code' => 'required|numeric|digits:4',
        ]);

        $is_valid = VerificationCodeService::checkAndDeleteUserVerificationCode($request->user()->id, $request->get('verification_code'));

        if ($is_valid) {
            $request->user()->markEmailAsVerified();
        }

        return \response([
            /**
             * @var boolean
             */
            'success' => $is_valid
        ], 200);
    }

    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return \response([
            'success' => true
        ], 200);
    }

    public function sendResetLink(Request $request): Response
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $email = $request->get('email');

        $token = PasswordService::genrateResetToken($email);
        $link = route('password.reset.user', [$request->language, $token]) . '?email=' . urlencode($email);
        Mail::to($email)->send(new SendPasswordResetLinkMail($email, $token, $link));

        return \response([
            'success' => true,
            'link' => $link
        ], 200);
    }
}
