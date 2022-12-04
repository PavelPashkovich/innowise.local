<?php
$page_title = "Add new user";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="container">
    <div class="row justify-content-center vh-100 align-items-center">
        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-10">
            <?php if (isset($error)): ?>
                <h3 class="text-center"><?php echo $error; ?></h3>
            <?php else: ?>
            <form class="form-container" role="form" action="/users" method="post" onsubmit="return validate();">
                <div class="mb-3">
                    <label class="form-label" for="email-create">Email</label>
                    <input class="form-control" type="email" id="email-create" name="email" placeholder="Email"
                           aria-describedby="emailHelp">
                    <?php if (isset($errors['email_error'])): ?>
                        <div id="emailHelp" class="form-text text-danger"><?php echo $errors['email_error'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name-create">Name</label>
                    <input class="form-control" type="text" id="name-create" name="name"
                           placeholder="First and last name" aria-describedby="nameHelp">
                    <?php if (isset($errors['name_error'])): ?>
                        <div id="nameHelp" class="form-text text-danger"><?php echo $errors['name_error'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="gender-create">Gender</label>
                    <select class="form-select" name="gender" id="gender-create">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="status-create">Status</label>
                    <select class="form-select" name="status" id="status-create">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button class="btn btn-outline-success" type="submit">Add</button>
                </div>

                <?php if (isset($errors['database_error'])): ?>
                    <div class="form-text text-danger"><?php echo $errors['database_error'] ?></div>
                <?php endif; ?>

                <?php endif; ?>
            </form>
        </div>
    </div>

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
