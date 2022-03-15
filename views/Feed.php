<?php
include 'Header.php';

/**
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
        <h1>Homepage</h1>
        <h3>Current User: <?= $_SESSION['username'] ?? '' ?></h3>
        <ul>
        <?php if (isset($_SESSION['id'])) { ?>
        <li><a href="<?php echo $routes->get('signout')->getPath(); ?>">Sign Out</a></li>
        <li><a href="<?php echo $routes->get('profile')->getPath(); ?>">Profile</a></li>
        <?php } else { ?>
        <li><a href="<?php echo $routes->get('signup')->getPath(); ?>">Sign Up</a></li>
        <li><a href="<?php echo $routes->get('signin')->getPath(); ?>">Sign In</a></li>
        <?php } ?>
        </ul>

    <section>
<?php include 'Footer.php'; ?>