<?php
$page_title = "User page";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="container">
    <div class="row justify-content-center vh-100 align-items-center">
        <div class="col-xl-9 col-lg-10 col-md-11 col-sm-12">
            <?php if (isset($error)): ?>
                <h3><?php echo $error; ?></h3>
            <?php else: ?>
                <?php if (isset($users)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-center bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="text-center align-middle">
                            <tr>
                                <td><?php echo $users['id']; ?></td>
                                <td class="text-start"><?php echo $users['name']; ?></td>
                                <td class="text-start"><?php echo $users['email']; ?></td>
                                <td><?php echo $users['gender']; ?></td>
                                <td><?php echo $users['status']; ?></td>
                                <td>
                                    <div class="container d-inline-flex justify-content-center">
                                        <form role="form" class="form-container" action="edit/<?php echo $users['id']; ?>" method="get">
                                            <button class="btn btn-outline-warning m-1" type="submit"><i class="bi bi-pencil-square"></i> Edit</button>
                                        </form>
                                        <form role="form" class="form-container" onsubmit="delete_confirm(event)" action="<?php echo $users['id']; ?>" method="post">
                                            <button class="btn btn-outline-danger m-1" type="submit"><i class="bi bi-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
