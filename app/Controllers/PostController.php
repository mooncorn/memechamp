<?php

namespace App\Controllers;

class PostController
{
    public function show(int $id) {
        require_once APP_ROOT . '/views/Post.php';
    }
}