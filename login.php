<?php
    //Always require core/functions.php
    require 'core/functions.php';

    redirect_if_authenticated('home');

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if($_POST['email'] == '') {
            add_message_error('Email is required');
            reload_page();
            exit;
        }
        if($_POST['password'] == '') {
            add_message_error('Password is required');
            reload_page();
            exit;
        }
        $login = login($_POST['email'], $_POST['password']);
        if (! $login['status']) {
            add_message_error($login['message']);
            reload_page();
        }
        reload_page();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Inventory Management</title>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="post">
        <input type="email" name="email">
        <input type="password" name="password">
        <input type="submit" value="Submit" name="submit">
    </form>
    <a href="register.php">Register</a>
</body>
</html>