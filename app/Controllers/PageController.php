<?php 

namespace App\Controllers;

use App\Models\Comment;
use App\Models\CommentForeignKey;

class PageController
{
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
    }

    public function comments(int $id)
    {
        global $pdo;

        $comments = Comment::fetchComments($pdo, CommentForeignKey::POST_ID, $id);


        echo "<pre>";
        print_r($comments);
        echo "</pre>";


        require_once APP_ROOT . '/views/PostComments.php';
    }
}