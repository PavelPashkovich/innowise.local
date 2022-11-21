<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <title>User Info</title>
</head>
<body>
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
</body>
</html>
