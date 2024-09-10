<?php

namespace App\Services;

use App\Jobs\SendSmsVerificationCodeJob;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class VerificationCodeService
{
    public static function generateUserVerificationCode($user_id): int
    {
        if (!App::isProduction()) {
            return 0000;
        }

        $verification_code = rand(1000, 9999);

        DB::table('verification_codes')
            ->insert([
                'user_id' => $user_id,
                'verification_code' => $verification_code,
                'created_at' => now(),
            ]);

        return $verification_code;
    }

    public static function checkAndDeleteUserVerificationCode($user_id, $verification_code): bool
    {
        if (!App::isProduction()) {
            return true;
        }

        $is_valid = DB::table('verification_codes')
            ->where([
                'user_id' => $user_id,
                'verification_code' => $verification_code,
            ])
            ->first();

        if ($is_valid) {
            DB::table('verification_codes')
                ->where([
                    'user_id' => $user_id,
                ])
                ->delete();
        }

        return (bool) $is_valid;
    }

    public static function sendSmsVerificationCode($phone, $user_id): void
    {
        if (App::isProduction()) {
            $verification_code = self::generateUserVerificationCode($user_id);
            $message = 'Your verification code: ' . $verification_code;
            SendSmsVerificationCodeJob::dispatch($phone, $message);
        }
    }
}
