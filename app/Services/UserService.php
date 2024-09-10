<?php

namespace App\Services;

use App\Enums\RolesEnum;
use App\Mail\SendVerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    public static function store(Request $request, RolesEnum $role)
    {
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($role);

        return $user;
    }

    public static function sendVerificationEmail($user): void
    {
        $verification_code = VerificationCodeService::generateUserVerificationCode($user->id);
        Mail::to($user->email)->send(new SendVerificationCodeMail($verification_code));
    }
}
