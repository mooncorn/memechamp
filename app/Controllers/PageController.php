<?php 

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

class PageController
{
	public function homepage(RouteCollection $routes, RequestContext $context)
	{
        // $generator = new UrlGenerator($routes, $context);
        // header('Location: ' . $generator->generate('profile', ['id' => '4']));
        
        require_once APP_ROOT . '/views/Feed.php';
	}

    public function signup(RouteCollection $routes, RequestContext $context)
    {
        require_once APP_ROOT . '/views/Signup.php';
    }
}