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

$routes->add('handle_signup', new Route(
    constant('URL_SUBFOLDER') . '/api/signup',
    array('controller' => 'UserController', 'method'=>'signup'),
    array(),
    array(),
    '',
    array(),
    array('POST')
));

$routes->add('signup', new Route(
    constant('URL_SUBFOLDER') . '/signup/{status}',
    array('controller' => 'PageController', 'method'=>'signup', 'status'=>'')
));

$routes->add('handle_signin', new Route(
    constant('URL_SUBFOLDER') . '/api/signin',
    array('controller' => 'UserController', 'method'=>'signin'),
    array(),
    array(),
    '',
    array(),
    array('POST')
));

$routes->add('signin', new Route(
    constant('URL_SUBFOLDER') . '/signin/{status}',
    array('controller' => 'PageController', 'method'=>'signin', 'status'=>'')
));

$routes->add('signout', new Route(
    constant('URL_SUBFOLDER') . '/api/signout',
    array('controller' => 'UserController', 'method'=>'signout')
));

$routes->add('profile', new Route(
    constant('URL_SUBFOLDER') . '/user/{userId}/{tab}',
    array('controller' => 'PageController', 'method'=>'profile', 'tab'=>'posts'),
    array('id' => '[0-9]+'),
    array(),
    '',
    array(),
    array('GET')
));

$routes->add('update_username', new Route(
    constant('URL_SUBFOLDER') . '/user/{id}/update/username/{status}',
    array('controller' => 'PageController', 'method'=>'update_username', 'status'=>''),
    array('id' => '[0-9]+')
));

$routes->add('handle_username_update', new Route(
    constant('URL_SUBFOLDER') . '/api/update/user/{id}/username',
    array('controller' => 'UserController', 'method'=>'update_username'),
    array('id' => '[0-9]+'),
    array(),
    '',
    array(),
    array('POST')
));

$routes->add('update_pfp', new Route(
    constant('URL_SUBFOLDER') . '/user/{id}/update/pfp/{status}',
    array('controller' => 'PageController', 'method'=>'update_pfp', 'status'=>''),
    array('id' => '[0-9]+')
));

$routes->add('handle_pfp_update', new Route(
    constant('URL_SUBFOLDER') . '/api/user/{id}/update/pfp',
    array('controller' => 'UserController', 'method'=>'update_pfp'),
    array('id' => '[0-9]+'),
    array(),
    '',
    array(),
    array('POST')
));

$routes->add('create_post', new Route(
    constant('URL_SUBFOLDER') . '/post/create',
    array('controller' => 'PostController', 'method'=>'createPost')
));

$routes->add('post', new Route(
    constant('URL_SUBFOLDER') . '/post/{id}',
    array('controller' => 'PostController', 'method'=>'show')
));

$routes->add('delete_comment', new Route(
    constant('URL_SUBFOLDER') . '/comment/{id}/delete',
    array('controller' => 'CommentController', 'method'=>'deleteOne'),
    array('id' => '[0-9]+')
));

$routes->add('reply_to_comment', new Route(
    constant('URL_SUBFOLDER') . '/comment/{id}/reply',
    array('controller' => 'CommentController', 'method'=>'replyToComment'),
    array('id' => '[0-9]+')
));

$routes->add('reply_to_post', new Route(
    constant('URL_SUBFOLDER') . '/post/{id}/comments/create',
    array('controller' => 'CommentController', 'method'=>'replyToPost'),
    array('id' => '[0-9]+')
));

$routes->add('edit_comment', new Route(
    constant('URL_SUBFOLDER') . '/comment/{id}/edit',
    array('controller' => 'CommentController', 'method'=>'editComment'),
    array('id' => '[0-9]+')
));

$routes->add('like_comment', new Route(
    constant('URL_SUBFOLDER') . '/comment/{id}/like',
    array('controller' => 'CommentController', 'method'=>'likeComment'),
    array('id' => '[0-9]+')
));

$routes->add('handle_vote', new Route(
    constant('URL_SUBFOLDER') . '/vote/post/{postId}/user/{userId}',
    array('controller' => 'VoteController', 'method'=>'handleVote'),
    array('postId' => '[0-9]+', 'userId' => '[0-9]+')
));

$routes->add('dashboard', new Route(
    constant('URL_SUBFOLDER') . '/dashboard',
    array('controller' => 'PageController', 'method'=>'dashboard')
));

// ================== (End) Routes ==================

// global url generator
$generator = new UrlGenerator($routes, new RequestContext());