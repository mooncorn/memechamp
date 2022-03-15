<?php include 'Header.php'; ?>
    <section>
        <h1>User</h1>
        <ul>
            <li><?= $user->getId() ?></li>
            <li><?= $user->getEmail() ?></li>
        </ul>
        <a href="<?php echo $routes->get('homepage')->getPath(); ?>">Back to homepage</a>
    <section>
<?php include 'Footer.php'; ?>