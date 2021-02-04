<form action="" method="POST">
    <input type="hidden" name="customerFormSent">
    <input type="hidden" name="customer[id]" value="<?= $customer['id'] ?? NULL ?>">
    <fieldset>
        <?php if ($editCustomer) : ?>
            <p>
                <a href="index.php">&lt;&lt; Cancel Edit Mode</a>
            </p>
        <?php endif ?>
        <legend><?= $editCustomer ? 'Edit' : 'Add new' ?> Customer</legend>
        <label for="firstname">First name *</label>
        <?php if (isset($error['firstname'])) : ?>
            <div class="error"><?= $error['firstname'] ?></div>
        <?php endif ?>
        <input type="text" name="customer[firstname]" id="firstname" value="<?= $customer['firstname'] ?? '' ?>">

        <label for="lastname">Last name *</label>
        <?php if (isset($error['lastname'])) : ?>
            <div class="error"><?= $error['lastname'] ?></div>
        <?php endif ?>
        <input type="text" name="customer[lastname]" id="lastname" value="<?= $customer['lastname'] ?? '' ?>">

        <label for="email">E-Mail adress *</label>
        <?php if (isset($error['email'])) : ?>
            <div class="error"><?= $error['email'] ?></div>
        <?php endif ?>
        <input type="text" name="customer[email]" id="email" value="<?= $customer['email'] ?? '' ?>">

        <label for="birthdate">Birthdate</label>
        <?php if (isset($error['birthdate'])) : ?>
            <div class="error"><?= $error['birthdate'] ?></div>
        <?php endif ?>
        <input type="date" name="customer[birthdate]" id="birthdate" value="<?= $customer['birthdate'] ?? '' ?>">

        <label for="city">City</label>
        <?php if (isset($error['city'])) : ?>
            <div class="error"><?= $error['city'] ?></div>
        <?php endif ?>
        <input type="text" name="customer[city]" id="city" value="<?= $customer['city'] ?? '' ?>">
    </fieldset>
    <button type="submit"><?= $editCustomer ? 'Edit' : 'Add' ?> Customer</button>
</form>