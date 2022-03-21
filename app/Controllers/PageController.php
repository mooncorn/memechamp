<?php 

namespace App\Controllers;

use App\Models\Comment;

class PageController
{
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
    }

    public function comments(int $id)
    {
        global $pdo;
        $comments = Comment::fetchCommentsWithOwnerAndReplies($pdo, 'post_id', 1);
        require_once APP_ROOT . '/views/PostComments.php';
    }
}