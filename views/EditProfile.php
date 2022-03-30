<?php

use App\Helpers\Routing;

/**
 * @var int $id
 * @var string $status
 */

include 'Header.php';

$fulfilled = $status == 'fulfilled';
$rejected = $status == 'rejected';

/**
 * @var int $id
 */

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
    <h1>Edit Profile</h1>
<hr>
    <div class="p-2 my-2 border rounded">
        <h3>Update Username</h3>
        <form enctype="multipart/form-data" action="/<?=constant('URL_SUBFOLDER')?>/api/update/user/<?=$id?>/username" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= $username ?? '' ?>">
                <?php if ($fulfilled) { ?>
                    <div class="text-success"><?= $_SESSION['form_update_username'] ?? "" ?></div>
                <?php } else if ($rejected) { ?>
                    <div class="text-danger"><?= $_SESSION['form_update_username'] ?? "" ?></div>
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <div class="p-2 my-2 border rounded">
        <h3>Update Profile Picture</h3>
        <form enctype="multipart/form-data" action="edit" method="post">
            <div class="mb-3">
                <label for="pfp" class="form-label">Profile Picture</label>
                <input type="file" name="pfp" class="form-control">
                <div class="text-success"><?= $messages["pfp"] ?? "" ?></div>
                <div class="text-danger"><?= $errors["pfp"] ?? "" ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <section>
<?php include 'Footer.php'; ?>