<?php
$page_title = "Users";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="wrapper">

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
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['gender']; ?></td>
                <td><?php echo $user['status']; ?></td>
                <td>
                    <div class="actions-container">
                        <form action="edit/<?php echo $user['id']; ?>" method="get">
                            <button>Edit</button>
                        </form>
                        <form onsubmit="delete_confirm(event)" action="<?php echo $user['id']; ?>" method="post">
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
</div>


<?php require_once __DIR__ . '/../footer_layout.php'; ?>
