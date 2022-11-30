<?php
$page_title = "Editing user";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="wrapper">
    <?php if (isset($error)): ?>
        <h3><?php echo $error; ?></h3>
    <?php else: ?>
    <?php if (isset($user)): ?>
    <form class="form-container" action="/users/update" method="post">
        <label for="email-edit">Email</label>
        <input type="email" id="email-edit" name="email" value="<?php echo $user['email']; ?>">
        <?php if (isset($errors['email_error'])): ?>
            <p class="error-message"><?php echo $errors['email_error'] ?></p>
        <?php endif; ?>

        <label for="name-edit">Name</label>
        <input type="text" id="name-edit" name="name" value="<?php echo $user['name']; ?>">
        <?php if (isset($errors['name_error'])): ?>
            <p class="error-message"><?php echo $errors['name_error'] ?></p>
        <?php endif; ?>

        <label for="gender-edit">
            <select name="gender" id="gender-edit">
                <option value="male" <?php if ($user['gender'] == 'male') { echo ' selected="selected"'; } ?>>Male</option>
                <option value="female" <?php if ($user['gender'] == 'female') { echo ' selected="selected"'; } ?>>Female</option>
            </select>
        </label>

        <label for="status-edit">
            <select name="status" id="status-edit">
                <option value="active" <?php if ($user['status'] == 'active') { echo ' selected="selected"'; } ?>>Active</option>
                <option value="inactive" <?php if ($user['status'] == 'inactive') { echo ' selected="selected"'; } ?>>Inactive</option>
            </select>
        </label>

        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <button type="submit">Confirm</button>

        <?php if (isset($errors['database_error'])): ?>
            <p class="error-message"><?php echo $errors['database_error'] ?></p>
        <?php endif; ?>

    </form>
    <?php endif; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
