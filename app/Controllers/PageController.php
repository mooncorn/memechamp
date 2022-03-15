<?php 

namespace App\Controllers;

use App\Models\Product;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
// use Symfony\Component\Routing\Generator\UrlGenerator;

class PageController
{
	public function homepage(RouteCollection $routes, RequestContext $context)
	{
    // $generator = new UrlGenerator($routes, $context);
    // echo $generator->generate('profile', ['id' => '4']);
    // header('Location: ' . $routes->get('profile')->getPath());        

    require_once APP_ROOT . '/views/Feed.php';
	}
}