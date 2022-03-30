<?php 

namespace App\Controllers;

use App\Helpers\Routing;
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