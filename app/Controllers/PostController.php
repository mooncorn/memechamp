<?php

namespace App\Controllers;

use App\Models\Post;

class PostController
{
    public function show(int $id) {
        require_once APP_ROOT . '/views/Post.php';
    }
}