<?php

$db = mysqli_connect(constant('DB_HOST'), constant("DB_USER"), constant('DB_PASS'), constant('DB_NAME'));

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
