<?php


namespace App\Utilities;


class Validation
{
    public static function is_valid_email(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;
        return false;
    }
}
