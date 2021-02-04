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

// Fetch all existing users from db
$customers = Customer::fetchAllCustomersFromDb($pdo);
$editCustomer = false; // small "cheat" to ease up form handling

// Handle URL parameters
if (isset($_GET['action'])) {
    $action = cleanString($_GET['action']);
    switch ($action) {
        case 'deleteCustomer':
            $selectedCustomer = $customers[cleanString($_GET['customer'])];
            if ($selectedCustomer->deleteFromDb($pdo)) {
                $transactionState = [
                    'state' => 'success',
                    'message' => 'Customer successfully deleted with ID: ' . $selectedCustomer->getCus_id()
                ];

                // TODO: Handle unset of customer correctly
                unset($selectedCustomer);
                header('Location: index.php');
            } else {
                $transactionState = [
                    'state' => 'error',
                    'message' => 'Customer could not be deleted. Please try again later'
                ];
            }
            break;

        case 'editCustomer':
            $selectedCustomer = $customers[cleanString($_GET['customer'])];
            $editCustomer = true;
            break;

        default:

            break;
    }
}

// Handle Form
if (isset($_POST['customerFormSent'])) {
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

        // Date formfield returns empty string as value if form is sent
        if ($customer['birthdate'] == '') {
            $date = NULL;
        } else {
            $date = new DateTime($customer['birthdate']);
        }

        $currentCustomer = new Customer(
            $customer['firstname'],
            $customer['lastname'],
            $customer['email'],
            $date,
            $customer['city'],
            $customer['id'] ?? NULL
        );

        if ($editCustomer) {
            if ($currentCustomer->updateToDb($pdo)) {
                $transactionState = [
                    'state' => 'success',
                    'message' => 'Customer successfully updated with ID: ' . $currentCustomer->getCus_id()
                ];

                unset($currentCustomer);
                $customer = [];
            } else {
                $transactionState = [
                    'state' => 'error',
                    'message' => 'Customer could not be updated. Please try again later'
                ];
            }
        } elseif (!$editCustomer && !$currentCustomer->emailExistsInDb($pdo)) {
            if ($currentCustomer->saveToDb($pdo)) {
                $transactionState = [
                    'state' => 'success',
                    'message' => 'Customer successfully saved with ID: ' . $currentCustomer->getCus_id()
                ];

                unset($currentCustomer);
                $customer = [];
            } else {
                $transactionState = [
                    'state' => 'error',
                    'message' => 'Customer could not be saved. Please try again later'
                ];
            }
        } else {
            $transactionState = [
                'state' => 'error',
                'message' => 'Customer email already exists. Please check your data'
            ];
        }
    }
}
?>

<!doctype html>

<html>

<head>
    <meta charset="utf-8">
    <title>Customer Management</title>
    <link rel="stylesheet" href="./css/debug.css">
    <link rel="stylesheet" href="./css/tutor.css">
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <h1>Customer Management</h1>

    <?php if (isset($customers)) : ?>
        <?php require_once('./partials/customerTable.inc.php'); ?>
    <?php endif ?>

    <hr>

    <?php if (isset($transactionState)) : ?>
        <div class="<?= $transactionState['state'] ?>">
            <?= $transactionState['message'] ?>
        </div>
    <?php endif ?>

    <?php require_once('./partials/customerForm.inc.php'); ?>
</body>

</html>