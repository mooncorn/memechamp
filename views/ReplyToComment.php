<?php

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Comment;
use App\Models\User;

include 'Header.php';

/**
 * @var Comment $comment
 * @var User $user owner of the comment
 * @var array $errors
 * @var string $content
 */

function renderComments(array $comments) {
    foreach ($comments as $commentWithOwnerAndReplies) {
        $comment = $commentWithOwnerAndReplies['Comment'];
        $user = $commentWithOwnerAndReplies['User'];
        $replies = $commentWithOwnerAndReplies['Replies'];
        ?>
        <li class="list-group-item">
            <div class="d-flex">
                <h5>
                    <?php if ($comment->isDeleted()) { ?>
                        <a href="#">[deleted]</a>
                    <?php } else { ?>
                        <a href="<?= Routing::getCustomUrlTo('profile', ['id'=>$user->getId()]) ?>"><?= $user->getUsername() ?></a>
                    <?php } ?>
                </h5>
                <small class="p-1"><?= $comment->getCreatedAt() ?></small>
                <?php if ($comment->isEdited()) { ?>
                    <small class="p-1">[edited]</small>
                <?php } ?>
            </div>

            <?php if ($comment->isDeleted()) { ?>
                <p>[deleted]</p>
            <?php } else { ?>
                <p><?= $comment->getContent() ?></p>
            <?php } ?>


            <div class="d-flex align-items-center">
                <div class="me-2">X Likes</div>
                <a href="#" class="me-2"><i class="far fa-heart me-1"></i></a>
                <a href="<?= Routing::getCustomUrlTo('reply_to_comment', ['id'=>$comment->getId()]) ?>" class="me-2"><i class="far fa-comment-alt me-1"></i></a>
                <a href="<?= Routing::getCustomUrlTo('comments', ['id'=>$comment->getId()]) ?>"><i class="far fa-comments me-1"></i><?= count($replies) ?></a>
            </div>
        </li>
        <?php
    }
}

?>

<style>
    section {
        max-width: 600px;
        padding: 20px;
    }
    input, label, small {
        display: block;
    }
</style>

<section class="mx-auto">

    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <h5>
                    <?php if ($comment->isDeleted()) { ?>
                        <a href="#">[deleted]</a>
                    <?php } else { ?>
                        <a href="<?= Routing::getCustomUrlTo('profile', ['id'=>$user->getId()]) ?>"><?= $user->getUsername() ?></a>
                    <?php } ?>
                </h5>


                <small class="p-1"><?= $comment->getCreatedAt() ?></small>
                <?php if ($comment->isEdited()) { ?>
                    <small class="p-1">[edited]</small>
                <?php } ?>
            </div>


            <?php if ($comment->isDeleted()) { ?>
                <p>[deleted]</p>
            <?php } else { ?>
                <p><?= $comment->getContent() ?></p>
            <?php } ?>

            <div class="d-flex align-items-center">
                <div class="me-2">X Likes</div>
                <a href="#" class="me-2"><i class="far fa-heart me-1"></i></a>
            </div>
        </div>


        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="content" class="form-label">Message</label>
                    <textarea type="text" name="content" class="form-control" value="<?= $content ?? '' ?>"></textarea>
                    <div class="text-danger"><?= $errors["content"] ?? "" ?></div>
                </div>
                <button type="submit" class="btn btn-primary">Reply</button>
            </form>
        </div>
    </div>

</section>

<?php include 'Footer.php'; ?>
