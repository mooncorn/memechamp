<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;

class CommentController
{
    public function deleteOne(int $id)
    {
        global $pdo;

        $comment = new Comment();
        if ($comment->load($pdo, $id))
        {
            if (Auth::isOwner($comment->getOwnerId()))
            {
                $comment->setDeleted('true');
                $comment->save($pdo);

                $postId = $comment->getPostId();
                Routing::redirectToCustomPage('comments', ['id' => $postId]);
            }
            else
            {
                require_once APP_ROOT . '/views/Unauthorized.php';
            }
        }
        else
        {
            require_once APP_ROOT . '/views/404.php';
        }
    }

    public function comments(int $id)
    {
        global $pdo;

        $comment = new Comment();
        if ($comment->load($pdo, $id))
        {
            $likes = Like::getNumberOfLikesForComment($pdo, $comment->getId());

            $user = new User();
            $user->load($pdo, 'id', $comment->getOwnerId());

            $replies = Comment::fetchCommentsAll($pdo, 'reply_to_id', $id);

            if ($comment->getReplyToId())
            {
                $replyToComment = new Comment();
                $replyToComment->load($pdo, $comment->getReplyToId());

                $replyToUser = new User();
                $replyToUser->load($pdo, 'id', $replyToComment->getOwnerId());
            }
            else
            {
                // get post info
            }

            require_once APP_ROOT . '/views/Comments.php';
        }
        else
        {
            require_once APP_ROOT . '/views/404.php';
        }
    }

    public function replyToComment(int $id)
    {
        global $pdo;
        $errors = [];

        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        $comment = new Comment();
        $comment->load($pdo, $id);

        $user= new User();
        $user->load($pdo, 'id', $comment->getOwnerId());

        if (isset($_POST['content']))
        {
            $content = filter_input(INPUT_POST, 'content');

            if ($content)
            {
                $newComment = new Comment();
                $newComment->setContent($content);
                $newComment->setReplyToId($id);
                $newComment->setOwnerId(Auth::get('id'));
                $newComment->setPostId($comment->getPostId());
                $newComment->save($pdo);

                Routing::redirectToCustomPage('comments', ['id'=>$id]);
            }
            else
            {
                $errors['content'] = 'Message is required';
            }
        }

        require_once APP_ROOT . '/views/ReplyToComment.php';
    }

    public function replyToPost(int $id)
    {
        global $pdo;
        $errors = [];

        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        if (isset($_POST['content']))
        {
            $content = filter_input(INPUT_POST, 'content');

            if ($content)
            {
                $newComment = new Comment();
                $newComment->setContent($content);
                $newComment->setOwnerId(Auth::get('id'));
                $newComment->setPostId($id);
                $newComment->save($pdo);

                Routing::redirectToCustomPage('post_comments', ['id'=>$id]);
            }
            else
            {
                $errors['content'] = 'Message is required';
            }
        }

        require_once APP_ROOT . '/views/ReplyToPost.php';
    }

    public function editComment(int $id) {
        global $pdo;
        $errors = [];

        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        $comment = new Comment();
        $comment->load($pdo, $id);

        if (!Auth::isOwner($comment->getOwnerId()))
        {
            require_once APP_ROOT . '/views/Unauthorized.php';
            return;
        }

        $content = $comment->getContent();

        if (isset($_POST['content']))
        {
            $content = filter_input(INPUT_POST, 'content');

            if ($content)
            {
                $comment->setContent($content);
                $comment->save($pdo);

                Routing::redirectToCustomPage('comments', ['id'=>$id]);
            }
            else
            {
                $errors['content'] = 'Message is required';
            }
        }
        
        require_once APP_ROOT . '/views/EditComment.php';
    }

    public function likeComment(int $id)
    {
        global $pdo;

        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        if (Like::exists($pdo, Auth::get('id'), $id))
        {
            Like::delete($pdo, Auth::get('id'), $id);
        }
        else
        {
            Like::create($pdo, Auth::get('id'), $id);
        }

        Routing::redirectToCustomPage('comments', ['id'=>$id]);
    }
}