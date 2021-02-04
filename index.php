<?php
require_once('./include/config.inc.php');
require_once('./include/db.inc.php');
require_once('./include/logger.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/kint.phar');
require_once('./include/classLoader.inc.php');

// OB because of Debug Messages in Frontend
ob_clean();

// Autoloader
spl_autoload_register('autoloadClasses');

// Establish db connection
$pdo = dbConnect();

// Small "cheat" to ease up form handling
$editCustomer = false;

// Initiate Controller
require_once('./controller/index.controller.php');
