<?php 

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

class PageController
{
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
	}
}