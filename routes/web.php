<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('product', new Route(constant('URL_SUBFOLDER') . '/user/{id}', array('controller' => 'UserController', 'method'=>'showAction'), array('id' => '[0-9]+')));