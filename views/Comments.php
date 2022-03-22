<?php
use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;

include 'Header.php';

/**
 * @var array $replies
 * @var Comment $comment
 * @var int $likes
 * @var User $user
 * @var Comment|null $replyToComment
 * @var User|null $replyToUser
 */

function renderComments(array $comments) {
    foreach ($comments as $commentWithAll) {
        $comment = $commentWithAll['Comment'];
        $user = $commentWithAll['User'];
        $replies = $commentWithAll['Replies'];

        ?>
        <li class="list-group-item">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <h5><a href="<?= Routing::getCustomUrlTo('profile', ['id'=>$user->getId()]) ?>"><?= $user->getUsername() ?></a></h5>
                    <small class="p-1"><?= $comment->getCreatedAt() ?></small>
                    <?php if ($comment->isEdited()) { ?>
                        <small class="p-1">[edited]</small>
                    <?php } ?>
                </div>

                <div>
                    <?php if (!$comment->isDeleted() && Auth::isOwner($comment->getOwnerId())) { ?>
                        <a href="<?= Routing::getCustomUrlTo('edit_comment', ['id'=>$comment->getId()]) ?>">Edit</a>
                        <a href="<?= Routing::getCustomUrlTo('delete_comment', ['id'=>$comment->getId()]) ?>">Delete</a>
                    <?php } ?>
                </div>
            </div>

            <p><?= $comment->getContent() ?></p>

            <div class="d-flex align-items-center">
                <div class="me-2"><?= $commentWithAll['Likes'] ?> Likes</div>
                <a href="<?= Routing::getCustomUrlTo('reply_to_comment', ['id'=>$comment->getId()]) ?>" class="me-2"><i class="far fa-comment-alt me-1"></i>Reply</a>
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
    <p>
        <?php if (isset($replyToComment)) { ?>
            <?php if ($replyToComment->isDeleted()) { ?>
                <a href="<?= Routing::getCustomUrlTo('comments', ['id'=>$replyToComment->getId()]) ?>"><i class="fas fa-chevron-left me-2"></i>Replying to [deleted]</a>
            <?php } else { ?>
                <a href="<?= Routing::getCustomUrlTo('comments', ['id'=>$replyToComment->getId()]) ?>"><i class="fas fa-chevron-left me-2"></i>Replying to <?= $replyToUser->getUsername() ?></a>
            <?php } ?>
        <?php } else { ?>
            <a href="<?= Routing::getCustomUrlTo('post_comments', ['id'=>$comment->getPostId()]) ?>"><i class="fas fa-chevron-left me-2"></i>Replying to post</a>
        <?php } ?>
    </p>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
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

                <div>
                    <?php if (!$comment->isDeleted() && Auth::isOwner($comment->getOwnerId())) { ?>
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
                <div class="me-2"><?= $likes ?> Likes</div>

                <a href="<?= Routing::getCustomUrlTo('reply_to_comment', ['id'=>$comment->getId()]) ?>" class="me-2"><i class="far fa-comment-alt me-1"></i>Reply</a>

                <a href="<?= Routing::getCustomUrlTo('like_comment', ['id'=>$comment->getId()]) ?>" class="me-2">
                    <?php global $pdo;
                    if (Like::exists($pdo, Auth::get('id'), $comment->getId())) { ?>
                        <i class="fas fa-heart me-1"></i>
                    <?php } else { ?>
                        <i class="far fa-heart me-1"></i>
                    <?php } ?>
                </a>
            </div>
        </div>

        <ul class="list-group list-group-flush">
            <?php renderComments($replies); ?>
        </ul>
    </div>
</section>

<?php include 'Footer.php'; ?>
