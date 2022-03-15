<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('profile', new Route(constant('URL_SUBFOLDER') . '/users/{id}', array('controller' => 'UserController', 'method'=>'showAction'), array('id' => '[0-9]+')));
$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method'=>'homepage')));