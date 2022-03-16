<?php
include 'Header.php';

/**
 * @var User $user
 * @var RouteCollection $routes
 * @var RequestContext $context
 * @var bool $belongsToCurrentUser
 * @var UrlGenerator $generator
 */

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
                <?php if ($belongsToCurrentUser) { ?>
                    <a class="btn btn-primary shadow" href="<?= $generator->generate('edit_profile', ['id' => $_SESSION['id']]) ?>">Edit</a>
                <?php } ?>
            </div>

        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Comments</a>
            </li>
        </ul>
    <section>
<?php include 'Footer.php'; ?>