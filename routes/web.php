<?php

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();

// ================== (Start) Routes ==================

$routes->add('homepage', new Route(
    constant('URL_SUBFOLDER') . '/',
    array('controller' => 'PageController', 'method'=>'homepage')
));

$routes->add('signup', new Route(
    constant('URL_SUBFOLDER') . '/signup',
    array('controller' => 'UserController', 'method'=>'signup'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'GET')
));

$routes->add('signin', new Route(
    constant('URL_SUBFOLDER') . '/signin',
    array('controller' => 'UserController', 'method'=>'signin'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'GET')
));

$routes->add('signout', new Route(
    constant('URL_SUBFOLDER') . '/signout',
    array('controller' => 'UserController', 'method'=>'signout')
));

$routes->add('profile', new Route(
    constant('URL_SUBFOLDER') . '/user/{id}/tab/{tab}',
    array('controller' => 'UserController', 'method'=>'profile', 'tab'=>'posts'),
    array('id' => '[0-9]+', 'tab'=>'.+'),
    array(),
    '',
    array(),
    array('GET')
));

$routes->add('edit_profile', new Route(
    constant('URL_SUBFOLDER') . '/user/{id}/edit',
    array('controller' => 'UserController', 'method'=>'edit_profile'),
    array('id' => '[0-9]+')
));

$routes->add('post', new Route(
    constant('URL_SUBFOLDER') . '/post/{id}',
    array('controller' => 'PostController', 'method'=>'show')
));
	
$routes->add('comments', new Route(
    constant('URL_SUBFOLDER') . '/post/{id}/comments',
    array('controller' => 'PageController', 'method'=>'comments'),
    array('id' => '[0-9]+')
));

$routes->add('delete_comment', new Route(
    constant('URL_SUBFOLDER') . '/comment/{id}/delete',
    array('controller' => 'CommentController', 'method'=>'deleteOne'),
    array('id' => '[0-9]+')
));

// ================== (End) Routes ==================

// global url generator
$generator = new UrlGenerator($routes, new RequestContext());