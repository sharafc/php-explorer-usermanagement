<?php

// Handle URL parameters
if (isset($_GET['action'])) {
    $action = cleanString($_GET['action']);
    switch ($action) {
        case 'deleteCustomer':
            $selectedCustomer = new Customer(cleanString($_GET['id']));
            if ($selectedCustomer->deleteFromDb($pdo)) {
                $transactionState = [
                    'state' => 'success',
                    'message' => 'Customer successfully deleted with ID: ' . $selectedCustomer->getCus_id()
                ];

                // TODO: Handle unset of customer correctly
                unset($selectedCustomer);
            } else {
                $transactionState = [
                    'state' => 'error',
                    'message' => 'Customer could not be deleted. Please try again later'
                ];
            }
            break;

        case 'editCustomer':
            $selectedCustomer = new Customer(cleanString($_GET['id']));
            $selectedCustomer->fetchFromDb($pdo);

            // enrich array for edit form
            $customer = [
                'id' => $selectedCustomer->getCus_id(),
                'firstname' => $selectedCustomer->getCus_firstname(),
                'lastname' => $selectedCustomer->getCus_lastname(),
                'email' => $selectedCustomer->getCus_email(),
                'birthdate' => ($selectedCustomer->getCus_birthdate() ? $selectedCustomer->getCus_birthdate()->format('Y-m-d') : NULL),
                'city' => $selectedCustomer->getCus_city()
            ];

            $editCustomer = true;
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

        // Date and ID formfields returns empty string as value if form is sent
        $date = NULL;
        if (!empty($customer['birthdate'])) {
            $date = new DateTime($customer['birthdate']);
        }

        $id = NULL;
        if (!empty($customer['id'])) {
            $id = $customer['id'];
        }

        $currentCustomer = new Customer(
            $id,
            $customer['firstname'],
            $customer['lastname'],
            $customer['email'],
            $date,
            $customer['city']
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

// Fetch all existing users from db
$customers = Customer::fetchAllCustomersFromDb($pdo);

// Embed view
require_once('./views/index.inc.php');
