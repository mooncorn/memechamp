<?php

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\CommentCollection;

include 'Header.php';

/**
 * @var CommentCollection $commentCollection
 */

function renderComments(CommentCollection $commentCollection) {
    if (!empty($commentCollection->getComments())) {
        foreach ($commentCollection->getComments() as $comment) {
            $indentationInPx = $commentCollection->getIndentation() * 25;
            $owner = $comment->getOwner();
            $username = $owner->getUsername();
            $createdAt = $comment->getCreatedAt();
            $linkToOwnerProfile = Routing::getCustomUrlTo('profile', ['id' => $comment->getOwnerId()]);
            $content = $comment->getContent();

            ?>

            <div style="text-indent: <?= $indentationInPx?>">
                <div>
                    <div class="d-flex justify-content-between">
                        <div class='d-flex'>

                            <?php if ($comment->isDeleted()) { ?>
                                <h5><a href='#'>[deleted]</a></h5>
                            <?php } else { ?>
                                <h5><a href='<?= $linkToOwnerProfile ?>'><?= $username ?></a></h5>
                            <?php } ?>

                            <small class='ms-2 mt-1' style='text-indent: 0'><?= $createdAt ?></small>
                        </div>

                        <?php if (!$comment->isDeleted()) { ?>
                            <?php if (Auth::isOwner($comment->getOwnerId())) { ?>
                                <div style='text-indent: 0'>
                                    <a href='#'>Edit</a>
                                    <a href="<?= Routing::getCustomUrlTo('delete_comment', ['id' => $comment->getId()]) ?>">Delete</a>
                                </div>
                            <?php } ?>
                        <?php } ?>


                    </div>

                    <?php if ($comment->isDeleted()) { ?>
                        <p>[deleted]</p>
                    <?php } else { ?>
                        <p><?= $content ?></p>
                    <?php } ?>

                </div>
            </div>

            <?php

            renderComments($comment->getReplies());
        }
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
<h1>Comments</h1>

<?php
renderComments($commentCollection);
?>

</section>

<?php include 'Footer.php'; ?>
