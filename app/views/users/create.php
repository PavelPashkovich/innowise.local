<?php
$page_title = "Add new user";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="wrapper">
    <?php if (isset($error)): ?>
        <h3><?php echo $error; ?></h3>
    <?php else: ?>
    <form class="form-container" action="/users" method="post" onsubmit="return validate();">
        <label for="email-create">Email</label>
        <input type="email" id="email-create" name="email" placeholder="Email">
        <?php if (isset($errors['email_error'])): ?>
            <p class="error-message"><?php echo $errors['email_error'] ?></p>
        <?php endif; ?>

        <label for="name-create">Name</label>
        <input type="text" id="name-create" name="name" placeholder="Your first and last name">
        <?php if (isset($errors['name_error'])): ?>
            <p class="error-message"><?php echo $errors['name_error'] ?></p>
        <?php endif; ?>

        <label for="gender-create">Gender</label>
            <select name="gender" id="gender-create">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

        <label for="status-create">Status</label>
            <select name="status" id="status-create">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

        <button type="submit">Add</button>

        <?php if (isset($errors['database_error'])): ?>
            <p class="error-message"><?php echo $errors['database_error'] ?></p>
        <?php endif; ?>

        <?php endif; ?>
    </form>
</div>

<!--<script>-->
<!---->
<!--    function validate() {-->
<!--        var userEmail = document.getElementById("email-create");-->
<!--        var userName = document.getElementById("name-create");-->
<!--        if(!userEmail.value) {-->
<!--            userEmail.style.border = "2px solid red";-->
<!--            return false;-->
<!--        }-->
<!--        if(!userName.value) {-->
<!--            userName.style.border = "2px solid red";-->
<!--            return false;-->
<!--        }-->
<!--        return true;-->
<!--    }-->
<!--</script>-->

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
