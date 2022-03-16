<?php
include 'Header.php';

/**
 * @var User $user
 * @var RouteCollection $routes
 */

$belongsToCurrentUser = $user->getId() == $_SESSION['id'];

?>
    <style>
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
                <?php if ($user->getPfp()) { ?>
                    <img class="rounded-circle shadow" src="<?= '/'.constant('URL_SUBFOLDER').'/public/images/uploads/pfps/'.$user->getPfp() ?>" width="150px"/>
                <?php } else { ?>
                    <img class="rounded-circle shadow" src="<?= '/'.constant('URL_SUBFOLDER').'/public/images/uploads/pfps/defaultpfp.jpg' ?>" width="150px"/>
                <?php } ?>

            </div>
            <div class="col py-3">
                <h2><?= $user->getUsername() ?></h2>

            </div>

            <div class="col text-end p-0 py-3">
                <?php if ($belongsToCurrentUser) { ?>
                    <button class="btn btn-primary shadow" href="#">Edit</button>
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