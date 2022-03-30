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
        if (User::exists(GetUserBy::ID, $userId))
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

    /**
     * @Route("/edit/user/{id}/{status}", name="edit_profile", method="GET")
     */
    public function editProfile(int $id, string $status)
    {
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";

        require_once APP_ROOT . '/views/EditProfile.php';
    }
}