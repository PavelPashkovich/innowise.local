<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <title>Add User</title>
</head>
<body>
<div class="wrapper">
    <form action="/users/create" method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email">

        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your first and last name">

        <label for="gender">
            <select name="gender" id="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </label>

        <label for="status">
            <select name="status" id="status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </label>

        <button type="submit">Add</button>
    </form>
</div>
</body>
</html>
