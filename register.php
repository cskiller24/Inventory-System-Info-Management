<?php
    //Always require core/functions.php
    require 'core/functions.php';

    redirect_if_authenticated('home');

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if($_POST['name'] == '') {
            add_message_error('Name is required');
            reload_page();
        }
        if($_POST['email'] == '') {
            add_message_error('Email is required');
            reload_page();
        }
        if($_POST['password'] == '') {
            add_message_error('Password is required');
            reload_page();
        }   
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        $register = register($data);
        if(! $register['status']) {
            add_message_error($register['message']);
            reload_page();
        } else {
            add_message_success($register['message']);
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
    <title>Register | Inventory Management</title>
</head>
<body>
    <h1>Register</h1>
    <?php include 'layouts/messages.php' ?>
    <form action="" method="post">
        <input type="email" name="email">
        <input type="text" name="name">
        <input type="password" name="password">
        <input type="submit" value="Submit" name="submit">
    </form>
    <a href="login.php">Login</a>
</body>
</html>