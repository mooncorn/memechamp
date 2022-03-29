<?php

namespace App\Services;

use App\Framework\Exceptions\InvalidFieldValueException;
use App\Helpers\Auth;
use App\Models\Enums\GetUserBy;
use App\Models\User;

class UserService
{
    /**
     * @throws InvalidFieldValueException
     */
    public static function createUser(string $username, string $email, string $password)
    {
        $user = User::build($username, $email, $password);
        $user->save();
        $user->load(GetUserBy::USERNAME, $username);
        Auth::setSession(['username'=>$user->getUsername(), 'id'=>$user->getId()]);
        $_SESSION["signup_message"] = "Signed up successfully";
    }
}