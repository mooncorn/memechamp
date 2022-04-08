<?php

namespace App\Controllers;

use App\Models\Enums\GetUserBy;
use App\Models\Post;
use App\Models\User;

class PostController
{
    public function show(int $id) {

         $post = new Post();
         if ($post->load($id))
         {
             $user = new User();
             $user->load(GetUserBy::ID, $post->getUserId());
             echo "<pre>";print_r($post);echo "</pre>";
             require_once APP_ROOT . '/views/Post.php';
         }
         else
         {
             require_once APP_ROOT . '/views/404.php';
         }
    }
}