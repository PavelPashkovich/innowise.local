<?php
$page_title = "Add new user";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="wrapper">
    <form action="/users" method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email">
        <?php if (isset($errors['email_error'])): ?>
            <p class="error-message"><?php echo $errors['email_error'] ?></p>
        <?php endif; ?>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your first and last name">
        <?php if (isset($errors['name_error'])): ?>
            <p class="error-message"><?php echo $errors['name_error'] ?></p>
        <?php endif; ?>

        <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

        <label for="status">Status</label>
            <select name="status" id="status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

        <button type="submit">Add</button>
    </form>
</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
