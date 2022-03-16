<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();

$routes->add('homepage', new Route(
    constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method'=>'homepage')
));

$routes->add('signup', new Route(
    constant('URL_SUBFOLDER') . '/signup',
    array('controller' => 'UserController', 'method'=>'signup'), array(), array(), '', array(), array('POST', 'GET')
));

$routes->add('signin', new Route(
    constant('URL_SUBFOLDER') . '/signin',
    array('controller' => 'UserController', 'method'=>'signin'), array(), array(), '', array(), array('POST', 'GET')
));

$routes->add('signout', new Route(
    constant('URL_SUBFOLDER') . '/signout',
    array('controller' => 'UserController', 'method'=>'signout')
));

$routes->add('profile', new Route(
    constant('URL_SUBFOLDER') . '/users/{id}',
    array('controller' => 'UserController', 'method'=>'profile'),
    array('id' => '[0-9]+')
));


//$routes->add('handle_signup', new Route(
//    constant('URL_SUBFOLDER') . '/handle_signup',
//    array('controller' => 'UserController', 'method'=>'handle_signup'), array(), array(), '', array(), array('POST')
//));