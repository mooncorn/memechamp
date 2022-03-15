<?php
// Start session
session_start();

// Autoloader
require_once '../vendor/autoload.php';

// Load Config
require_once '../config/config.php';
// Connect to db
require_once '../config/db.php';

// Routes
require_once '../routes/web.php';
require_once '../app/Router.php';