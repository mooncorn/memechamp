<?php

/**
 * @var RouteCollection $routes
 * @var RequestContext $context
 * @var User $user
 */

use Symfony\Component\Routing\Generator\UrlGenerator;

$belongsToCurrentUser = isset($_SESSION['id']) && isset($user) && $user->getId() == $_SESSION['id'];
$generator = new UrlGenerator($routes, $context);

?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="<?='/'.constant('URL_SUBFOLDER').'/public/images/icon.png'?>">
    <link rel="stylesheet" href="<?=constant('URL_SUBFOLDER').'/public/css/style.css'?>">
    <title>MemeChamp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<style>
    .pfp-wrapper {
        /*width: 80px;*/
        /*height: 80px;*/
        overflow: hidden;
    }
    .pfp {
        height: inherit;
        width: inherit;
        object-fit: cover;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $routes->get('homepage')->getPath() ?>">
            MemeChamp
        </a>

        <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= $routes->get('homepage')->getPath() ?>">Feed</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['id'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $generator->generate('profile', ['id' => $_SESSION['id']]) ?>"><?= $_SESSION['username'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $routes->get('signout')->getPath() ?>">Sign Out</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $routes->get('signup')->getPath() ?>">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $routes->get('signin')->getPath() ?>">Sign In</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

