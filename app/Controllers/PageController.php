<?php 

namespace App\Controllers;

class PageController
{
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
    }
}