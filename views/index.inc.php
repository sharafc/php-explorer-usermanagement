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
        <?php require_once('./views/partials/customerTable.inc.php'); ?>
    <?php endif ?>

    <hr>

    <?php if (isset($transactionState)) : ?>
        <div class="<?= $transactionState['state'] ?>">
            <?= $transactionState['message'] ?>
        </div>
    <?php endif ?>

    <?php require_once('./views/partials/customerForm.inc.php'); ?>
</body>

</html>