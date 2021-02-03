<?php
require_once('./include/config.inc.php');
require_once('./include/db.inc.php');
require_once('./include/logger.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/dateTime.inc.php');
require_once('./include/kint.phar');
require_once('./include/classLoader.inc.php');

// Autoloader
spl_autoload_register('autoloadClasses');

$pdo = dbConnect();

$customer = new Customer();
//d($customer);

?>

<!doctype html>

<html>

<head>
    <meta charset="utf-8">
    <title>Customer Management</title>
    <link rel="stylesheet" href="./css/debug.css">
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <h1>Customer Management</h1>



</body>

</html>