<?php

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Comment;
use App\Models\Enums\ReplyTarget;
use App\Models\Like;

include 'Header.php';

/**
 * @var int $postId
 */


function show_comments(int $postId) {
    $comments = Comment::getReplies($postId, ReplyTarget::POST);

    show_replies($comments);
}

function show_replies(array $comments, $level = 0) {
    if (empty($comments)) {
        return;
    }

    foreach ($comments as $comment) {
        show_comment($comment, $level);
        $replies = Comment::getReplies($comment->getId());
        show_replies($replies, $level+1);
    }
}

function show_comment($comment, $level = 0) {
    $owner = $comment->getOwner();

    ?>

    <li class="list-group-item border-0 px-2 py-0">

        <div class="d-flex">
            <div class="d-flex">
            <?php
            for ($i = 0; $i < $level; $i++) {
                echo "<div class='h-100' style='width: 25px'><div style='width: 2px' class='h-100 mx-auto bg-secondary'></div></div>";
            }
            ?>
            </div>

            <div class="d-block p-2 w-100">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <h5>
                        <?php if ($comment->isDeleted()) { ?>
                            <a href="#">[deleted]</a>
                        <?php } else { ?>
                            <a href="<?= Routing::getCustomUrlTo('profile', ['id'=>$owner->getId()]) ?>"><?= $owner->getUsername() ?></a>
                        <?php } ?>
                    </h5>
                    <small class="p-1"><?= $comment->getCreatedAt() ?></small>
                    <?php if ($comment->isEdited()) { ?>
                        <small class="p-1">[edited]</small>
                    <?php } ?>
                </div>

                <div>
                    <?php if (!$comment->isDeleted() && Auth::isOwner($owner->getId())) { ?>
                        <a href="<?= Routing::getCustomUrlTo('edit_comment', ['id'=>$comment->getId()]) ?>">Edit</a>
                        <a href="<?= Routing::getCustomUrlTo('delete_comment', ['id'=>$comment->getId()]) ?>">Delete</a>
                    <?php } ?>
                </div>
            </div>

            <?php if ($comment->isDeleted()) { ?>
                <p>[deleted]</p>
            <?php } else { ?>
                <p><?= $comment->getContent() ?></p>
            <?php } ?>

            <div class="d-flex align-items-center">
                <div class="me-2"><?= $comment->getLikes() ?> Likes</div>
                <a href="<?= Routing::getCustomUrlTo('reply_to_comment', ['id'=>$comment->getId()]) ?>" class="me-2"><i class="far fa-comment-alt me-1"></i>Reply</a>

                <a href="<?= Routing::getCustomUrlTo('like_comment', ['id'=>$comment->getId()]) ?>" class="me-2">
                    <?php if (Like::exists(Auth::get('id') ?? 0, $comment->getId())) { ?>
                        <i class="fas fa-heart me-1"></i>
                    <?php } else { ?>
                        <i class="far fa-heart me-1"></i>
                    <?php } ?>
                </a>

            </div>
            </div>
        </div>
    </li>

    <?php } ?>

<style>
    section {
        max-width: 600px;
        padding: 20px;
    }
</style>

<section class="mx-auto">
    <p><a href="<?= Routing::getCustomUrlTo('reply_to_post', ['id'=>$postId]) ?>">Create a comment</a></p>
    <div class="card">
        <div class="card-header">
            <h1>Comments</h1>
            <p><?= Comment::getCount($postId, ReplyTarget::POST) ?> Comments</p>
        </div>

        <ul class="list-group list-group-flush">
            <?php show_comments($postId); ?>
        </ul>
    </div>
</section>

<?php include 'Footer.php'; ?>
