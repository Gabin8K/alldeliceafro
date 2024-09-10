<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordService
{
    public static function genrateResetToken(string $email): string
    {
        $database_token = DB::table('password_reset_tokens')
                                ->where([
                                    'email' => $email,
                                ])
                                ->first();

        if ($database_token == null) {
            $token = Str::random(60);

            DB::table('password_reset_tokens')
                ->insert([
                    'email' => $email,
                    'token' => $token,
                    'created_at' => now(),
                ]);

            return $token;
        }

        return $database_token->token;
    }

    public static function checkAndDeleteResetToken($email, $token): bool
    {
        $is_valid = self::checkResetTokenValidity($email, $token);

        if ($is_valid) {
            DB::table('password_reset_tokens')
                ->where([
                    'email' => $email,
                ])
                ->delete();
        }

        return (bool) $is_valid;
    }

    public static function checkResetTokenValidity($email, $token): bool
    {
        $is_valid = DB::table('password_reset_tokens')
            ->where([
                'email' => $email,
                'token' => $token,
            ])
            ->first();

        return (bool) $is_valid;
    }
}
