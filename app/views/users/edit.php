<?php
$page_title = "Editing user";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="wrapper">
    <form action="/users/update" method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">

        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>">

        <label for="gender">
            <select name="gender" id="gender">
                <option value="male" <?php if ($user['gender'] == 'male') { echo ' selected="selected"'; } ?>>Male</option>
                <option value="female" <?php if ($user['gender'] == 'female') { echo ' selected="selected"'; } ?>>Female</option>
            </select>
        </label>

        <label for="status">
            <select name="status" id="status">
                <option value="active" <?php if ($user['gender'] == 'active') { echo ' selected="selected"'; } ?>>Active</option>
                <option value="inactive" <?php if ($user['gender'] == 'inactive') { echo ' selected="selected"'; } ?>>Inactive</option>
            </select>
        </label>

        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <button type="submit">Confirm</button>
    </form>
</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
