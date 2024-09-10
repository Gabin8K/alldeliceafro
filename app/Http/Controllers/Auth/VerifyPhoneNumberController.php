<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\VerificationCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class VerifyPhoneNumberController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|max_digits:4'
        ]);

        if (VerificationCodeService::checkAndDeleteUserVerificationCode(
            user_id: $request->user()->id,
            verification_code: $request->code
        )) {
            Restaurant::query()
                ->where('user_id', $request->user()->id)
                ->update([
                    'phone_verified_at' => now()
                ]);

            return Redirect::back()->with('success', 'Success');
        }

        throw ValidationException::withMessages(['code' => 'Code value is incorrect']);
    }

    public function getSmsCode(Request $request)
    {
        if ($request->user()->restaurant->phone_verified_at == null) {
            VerificationCodeService::sendSmsVerificationCode(
                phone: $request->user()->restaurant->phone,
                user_id: $request->user()->id
            );
        }

        return Redirect::back()->with('success', 'Success');
    }
}
