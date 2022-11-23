<?php
$page_title = "User info";
require_once __DIR__ . '/../header_layout.php';
?>

<div class="wrapper">
    <?php
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                echo ucfirst($key) . ': ' . $value . '<br>';
            }
        }
        echo $data;
    ?>
</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
