<?php 

namespace App\Controllers;

use App\Models\CommentCollection;

class PageController
{
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
    }

    public function comments(int $id) {
        // get a list of comments
        $commentCollection = new CommentCollection();
        $commentCollection->load('post_id', $id);

        require_once APP_ROOT . '/views/Comments.php';
    }
}