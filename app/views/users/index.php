<?php
$page_title = "Users";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="container">
    <div class="row justify-content-center vh-100 align-items-center">
        <div class="col-xl-9 col-lg-10 col-md-11 col-sm-12">
            <?php if (isset($error)): ?>
                <h3 class="text-center"><?php echo $error; ?></h3>
            <?php else: ?>
            <?php if (isset($users) && count($users) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="text-center bg-light">
                    <tr>
                        <th>ID</th>
                        <th class="text-start">Name</th>
                        <th class="text-start">Email</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody class="text-center align-middle">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td class="text-start"><?php echo $user['name']; ?></td>
                            <td class="text-start"><?php echo $user['email']; ?></td>
                            <td><?php echo $user['gender']; ?></td>
                            <td><?php echo $user['status']; ?></td>
                            <td>
                                <div class="container d-inline-flex justify-content-center">
                                    <form role="form" class="form-container" action="users/<?php echo $user['id']; ?>" method="get">
                                        <button class="btn btn-outline-primary m-1" type="submit"><i class="bi-eye"></i> Show</button>
                                    </form>
                                    <form role="form" class="form-container" action="users/edit/<?php echo $user['id']; ?>" method="get">
                                        <button class="btn btn-outline-warning m-1" type="submit"><i class="bi bi-pencil-square"></i> Edit</button>
                                    </form>
                                    <form role="form" class="form-container" onsubmit="delete_confirm(event)" action="users/<?php echo $user['id']; ?>"
                                          method="post">
                                        <button class="btn btn-outline-danger m-1" type="submit"><i class="bi bi-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <?php else: ?>
                        <h3 class="text-center">There are no users yet. You can add new user.</h3>
                    <?php endif; ?>
                    <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
