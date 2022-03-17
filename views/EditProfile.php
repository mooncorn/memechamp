<?php

use App\Helpers\Routing;

include 'Header.php';

/**
 * @var array $errors
 * @var array $messages
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
        <form enctype="multipart/form-data" action="edit" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= $username ?? '' ?>">
                <div class="text-success"><?= $messages["username"] ?? "" ?></div>
                <div class="text-danger"><?= $errors["username"] ?? "" ?></div>
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