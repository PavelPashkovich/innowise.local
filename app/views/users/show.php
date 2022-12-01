<?php
$page_title = "Users";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="wrapper">

    <?php if (isset($error)): ?>
        <h3><?php echo $error; ?></h3>
    <?php else: ?>
    <?php if (isset($users)): ?>
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
                <td><?php echo $users['id']; ?></td>
                <td><?php echo $users['name']; ?></td>
                <td><?php echo $users['email']; ?></td>
                <td><?php echo $users['gender']; ?></td>
                <td><?php echo $users['status']; ?></td>
                <td>
                    <div class="actions-container">
                        <form action="edit/<?php echo $users['id']; ?>" method="get">
                            <button>Edit</button>
                        </form>
                        <form onsubmit="delete_confirm(event)" action="<?php echo $users['id']; ?>" method="post">
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>
    <?php endif; ?>
</div>


<?php require_once __DIR__ . '/../footer_layout.php'; ?>
