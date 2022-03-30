<?php 

namespace App\Controllers;

use App\Helpers\Routing;
use App\Models\Enums\GetUserBy;
use App\Models\User;
use App\Models\Vote;

class PageController
{
    /**
     * @Route("/", name="homepage", method="GET")
     */
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
    }

    /**
     * @Route("/user/{userId}/{tab}", name="profile", method="GET")
     */
    public function profile(int $userId, string $tab)
    {
        $id = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
        if (User::exists(GetUserBy::ID, $id))
        {
            require_once APP_ROOT . '/views/Profile.php';
        }
        else
        {
            require_once APP_ROOT . '/views/404.php';
        }
    }

    /**
     * @Route("/signup/{status}", name="signup", method="GET")
     */
    public function signup(string $status)
    {
        require_once APP_ROOT . '/views/Signup.php';
    }

    /**
     * @Route("/signin/{status}", name="signin", method="GET")
     */
    public function signin(string $status)
    {
        require_once APP_ROOT . '/views/Signin.php';
    }
}