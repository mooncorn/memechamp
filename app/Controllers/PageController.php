<?php 

namespace App\Controllers;

use App\Helpers\Routing;
use App\Models\Vote;

class PageController
{
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
    }

    public function signup(string $status)
    {
        require_once APP_ROOT . '/views/Signup.php';
    }
}