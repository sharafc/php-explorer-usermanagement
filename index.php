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

// Establish db connection
$pdo = dbConnect();

// Fetch all existing users from db
$customers = Customer::fetchAllCustomersFromDb($pdo);

if (isset($_POST['addCustomerSent'])) {
    logger('Add Customer form sent', $_POST, LOGGER_INFO);

    foreach ($_POST['customer'] as $key => $value) {
        $customer[$key] = cleanString($value);
    }

    $error = [
        'firstname' => checkInputString($customer['firstname']),
        'lastname' => checkInputString($customer['lastname']),
        'email' => checkEmail($customer['email'])
    ];

    $errorMap = array_map('trim', $error);
    $errorMap = array_filter($errorMap);

    if (count($errorMap) === 0) {
        logger('Add Customer form has no errors', __LINE__, LOGGER_INFO);

        $currentCustomer = new Customer(
            $customer['firstname'],
            $customer['lastname'],
            $customer['email'],
            new DateTime(),
            $customer['city']
        );

    }
}
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

    <?php if (isset($customers)) : ?>
        <?php require_once('./partials/customerTable.inc.php'); ?>
    <?php endif ?>

    <?php require_once('./partials/addCustomerForm.inc.php'); ?>

</body>

</html>