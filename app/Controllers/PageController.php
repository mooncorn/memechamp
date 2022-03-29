<?php 

namespace App\Controllers;

use App\Models\Vote;

class PageController
{
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
    }
}