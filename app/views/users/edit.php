<?php
$page_title = "Editing user";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="container">
    <div class="row justify-content-center vh-100 align-items-center">
        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-10">
            <?php if (isset($error)): ?>
                <h3 class="text-center"><?php echo $error; ?></h3>
            <?php else: ?>
                <?php if (isset($users)): ?>
                    <form class="form-container" role="form" action="/users/update" method="post">
                        <div class="mb-3">
                            <label class="form-label" for="email-edit">Email</label>
                            <input class="form-control" type="text" id="email-edit" name="email"
                                   value="<?php echo $users['email']; ?>" aria-describedby="emailHelp">
                            <?php if (isset($errors['email_error'])): ?>
                                <div id="emailHelp"
                                     class="form-text text-danger"><?php echo $errors['email_error'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name-edit">Name</label>
                            <input class="form-control" type="text" id="name-edit" name="name"
                                   value="<?php echo $users['name']; ?>" aria-describedby="nameHelp">
                            <?php if (isset($errors['name_error'])): ?>
                                <div id="nameHelp"
                                     class="form-text text-danger"><?php echo $errors['name_error'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="gender-edit">Gender</label>
                            <select class="form-select" name="gender" id="gender-edit">
                                <option value="male" <?php if ($users['gender'] == 'male') {
                                    echo ' selected="selected"';
                                } ?>>Male
                                </option>
                                <option value="female" <?php if ($users['gender'] == 'female') {
                                    echo ' selected="selected"';
                                } ?>>Female
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status-edit">Status</label>
                            <select class="form-select" name="status" id="status-edit">
                                <option value="active" <?php if ($users['status'] == 'active') {
                                    echo ' selected="selected"';
                                } ?>>Active
                                </option>
                                <option value="inactive" <?php if ($users['status'] == 'inactive') {
                                    echo ' selected="selected"';
                                } ?>>Inactive
                                </option>
                            </select>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $users['id']; ?>">

                        <div class="d-grid">
                            <button class="btn btn-outline-success" type="submit">Confirm</button>
                        </div>

                        <?php if (isset($errors['database_error'])): ?>
                            <div class="form-text text-danger"><?php echo $errors['database_error'] ?></div>
                        <?php endif; ?>

                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
