<?php
$page_title = "Users";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="wrapper">
    <?php if (isset($error)): ?>
    <h3><?php echo $error; ?></h3>
    <?php else: ?>
    <?php if (isset($users) && count($users) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Status</th>
            <th colspan="3">Actions</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['gender']; ?></td>
                <td><?php echo $user['status']; ?></td>
                <td>
                    <div class="actions-container">
                        <form action="users/<?php echo $user['id']; ?>" method="get">
                            <button type="submit">Show</button>
                        </form>
                        <form action="users/edit/<?php echo $user['id']; ?>" method="get">
                            <button>Edit</button>
                        </form>
                        <form onsubmit="delete_confirm(event)" action="users/<?php echo $user['id']; ?>" method="post">
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    <?php else: ?>
    <h2>There no users yet. You can add new user.</h2>
    <?php endif; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
