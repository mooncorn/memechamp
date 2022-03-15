<?php
include 'Header.php';

/**
 * @var User $user
 * @var RouteCollection $routes
 */

?>
    <style>
        section {
            padding: 20px;
        }
        input, label, small {
            display: block;
        }
    </style>

    <section>
        <h1>User Profile</h1>
        <ul>
            <li>Id: <?= $user->getId() ?></li>
            <li>Email: <?= $user->getEmail() ?></li>
            <li>Username: <?= $user->getUsername() ?></li>
        </ul>

        <a href="<?php echo $routes->get('homepage')->getPath(); ?>">Back to homepage</a>
    <section>
<?php include 'Footer.php'; ?>