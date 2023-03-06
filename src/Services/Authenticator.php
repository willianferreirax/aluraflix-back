<?php

namespace App\Services;

use App\Models\User;

class Authenticator{
    
    public static function authenticate(User $user, string $pass): bool{
        return password_verify($pass, $user->getPass());
    }

}