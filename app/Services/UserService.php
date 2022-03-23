<?php

namespace App\Services;

use App\Helpers\DBConnection;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, PDO $pdo)
    {
        $this->userRepository = $userRepository;
    }

    public function register(string $username, string $email, string $password) {
        $pdo = DBConnection::getDB();
        $user = new UserRepository();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->save();
    }
}