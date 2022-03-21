<?php

use App\Helpers\Routing;

include 'Header.php';

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
        <a href="<?= Routing::getCustomUrlTo('post_comments', ['id' => 1]) ?>">Go to Post 1</a>
    <section>
<?php include 'Footer.php'; ?>