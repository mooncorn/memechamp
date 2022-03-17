<?php

namespace App\Helpers;

class Routing
{
    public static function getUrlTo(string $page): string {
        global $routes;
        return $routes->get($page)->getPath();
    }

    public static function getCustomUrlTo(string $page, array $parameters): string {
        global $generator;
        return $generator->generate($page, $parameters);
    }

    public static function redirectTo(string $url) {
        header('Location: ' . $url);
    }
}