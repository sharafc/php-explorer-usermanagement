<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>E-Mail</th>
        <th>Birthdate</th>
        <th>City</th>
        <th>Edit</th>
    </tr>
    <?php foreach ($customers as $key => $value) : ?>
        <tr>
            <td><?= $value->getCus_id() ?></td>
            <td><?= $value->getFullName() ?></td>
            <td><a href="mailto:<?= $value->getCus_email() ?>?bcc=customerservice@meineseite.de&subject=Message from meineseite.de"><?= $value->getCus_email() ?></a></td>
            <td><?= $value->getCus_birthdate() ? $value->getCus_birthdate()->format('d.m.Y') :  '' ?></td>
            <td><?= $value->getCus_city() ?? '' ?></td>
            <td>
                <a href="?action=editCustomer&customer=<?= $key ?>">Edit</a> /
                <a href="?action=deleteCustomer&customer=<?= $key ?>" onclick="return confirm('Please confirm to delete Customer <?= $value->getFullName() ?>')">Delete</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>