<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>E-Mail</th>
        <th>Birthdate</th>
        <th>City</th>
        <th>Edit</th>
    </tr>
    <?php foreach ($customers as $value) : ?>
        <tr>
            <td><?= $value->getCus_id() ?></td>
            <td><?= $value->getFullName() ?></td>
            <td><?= $value->getCus_email() ?></td>
            <td><?= $value->getCus_birthdate()->format('Y-m-d') ??  '' ?></td>
            <td><?= $value->getCus_city() ?? '' ?></td>
            <td>Edit / Delete</td>
        </tr>
    <?php endforeach ?>
</table>