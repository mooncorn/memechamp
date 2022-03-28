<?php

namespace App\Controllers;

use App\Models\Post;

class PostController
{
    public function show(int $id) {

        $post = new Post();
        $post->setUserId(1);
        $post->setCompId(1);
        $post->save();



        echo "<pre>";
        print_r($post);
        echo "</pre>";

        require_once APP_ROOT . '/views/Post.php';
    }
}