<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function login(): Response
    {
        return Inertia::render('Admin/Auth/Login');
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
        if ($user && Hash::check($request->password, $user->password) && $user->hasRole([RolesEnum::ADMIN]) && $user->email_verified_at !== null) {
            Auth::login($user);

            return Redirect::route('admin.dashboard', $request->language);
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::route('welcome', $request->language);
    }
}
