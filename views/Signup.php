<?php

use App\Helpers\Routing;

include 'Header.php';

/**
 * @var Routing
 * @var array $errors
 * @var string $username;
 * @var string $email;
 * @var string $password;
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
    <h1 class="text-center">Sign Up</h1>

    <?php if (isset($_SESSION["form_signup"]["error"])) { ?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION["form_signup"]["error"] ?? "" ?>
    </div>
    <?php } ?>

    <form action="api/signup" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= $_SESSION["form_signup"]["values"]["username"] ?? '' ?>">

        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="<?= $_SESSION["form_signup"]["values"]["email"] ?? '' ?>">

        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" value="<?= $_SESSION["form_signup"]["values"]["password"] ?? '' ?>">

        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>

    </form>
<section>
<?php include 'Footer.php'; ?>