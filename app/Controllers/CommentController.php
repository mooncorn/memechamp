<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Comment;

class CommentController
{
    public function deleteOne(int $id) {
        $comment = new Comment();
        if ($comment->load($id)) {
            if (Auth::isOwner($comment->getOwnerId())) {
                $comment->delete();

                $postId = $comment->getPostId();
                Routing::redirectToCustomPage('comments', ['id' => $postId]);
            }
        } else {
            require_once APP_ROOT . '/views/404.php';
        }

    }
}