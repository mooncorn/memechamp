<?php
include 'Header.php';

/**
 * @var RouteCollection $routes
 * @var array $errors
 * @var string $username;
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
    <h1 class="text-center">Sign In</h1>

    <form action="signin" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= $username ?? '' ?>">
            <div class="text-danger"><?= $errors["username"] ?? "" ?></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" value="<?= $password ?? '' ?>">
            <div class="text-danger"><?= $errors["password"] ?? "" ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
        <div class="text-danger"><?= $errors["main"] ?? "" ?></div>
    </form>

    <a href="<?php echo $routes->get('homepage')->getPath(); ?>">Back to homepage</a>
    <section>
<?php include 'Footer.php'; ?>