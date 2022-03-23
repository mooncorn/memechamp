<?php

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Repositories\UserRepository;

include 'Header.php';

/**
 * @var Auth
 * @var Routing
 * @var UserRepository $user
 * @var string $tab
 * @var array $comments
 */

function renderComments(array $comments) {
    if (empty($comments)) {
        echo "no comments";
        return;
    }

    echo "<ul class='list-group mt-3'>";
    foreach ($comments as $comment) {
        if (!$comment->isDeleted()) {
            $content = $comment->getContent();
            echo "<li class='list-group-item'>$content</li>";
        }
    }
    echo "</ul>";
}

?>
    <style>
        .pfp-wrapper {
            width: 160px;
            height: 160px;
            overflow: hidden;
        }
        .pfp {
            height: inherit;
            width: inherit;
            object-fit: cover;
        }
        section {
            padding: 20px;
            max-width: 600px;
        }
        input, label, small {
            display: block;
        }
        ul {
            list-style: none;
            padding: 0;
        }
    </style>

    <section class="mx-auto">
        <div class="row border rounded shadow p-3 mb-4">
            <div class="col p-0 m-0">
                <div class="pfp-wrapper rounded-circle shadow">
                    <?php if ($user->getPfp()) { ?>
                        <img class="pfp" src="<?= '/'.constant('URL_SUBFOLDER').'/public/images/uploads/pfps/'.$user->getPfp() ?>"/>
                    <?php } else { ?>
                        <img class="pfp" src="<?= '/'.constant('URL_SUBFOLDER').'/public/images/uploads/pfps/defaultpfp.jpg' ?>"/>
                    <?php } ?>
                </div>
            </div>
            <div class="col py-3">
                <h2><?= $user->getUsername() ?></h2>

            </div>

            <div class="col text-end p-0 py-3">
                <?php if (Auth::isOwner($user->getId())) { ?>
                    <a class="btn btn-primary shadow" href="<?= Routing::getCustomUrlTo('edit_profile', ['id' => Auth::get('id')]) ?>">Edit</a>
                <?php } ?>
            </div>

        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?= $tab == 'posts' ? 'active' : '' ?>" href="<?= Routing::getCustomUrlTo('profile', ['id' => $user->getId()]) ?>">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tab == 'comments' ? 'active' : '' ?>" href="<?= Routing::getCustomUrlTo('profile', ['id' => $user->getId(), 'tab' => 'comments']) ?>">Comments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tab == 'voted' ? 'active' : '' ?>" href="<?= Routing::getCustomUrlTo('profile', ['id' => $user->getId(), 'tab' => 'voted']) ?>">Voted</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tab == 'liked' ? 'active' : '' ?>" href="<?= Routing::getCustomUrlTo('profile', ['id' => $user->getId(), 'tab' => 'liked']) ?>">Liked</a>
            </li>
        </ul>

        <?php
            if ($tab == 'comments') {
                renderComments($comments);
            }
        ?>

    <section>
<?php include 'Footer.php'; ?>