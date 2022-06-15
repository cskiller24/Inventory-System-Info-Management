<?php
    //Always require core/functions.php
    require 'core/functions.php';

    redirect_if_authenticated('home');

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if($_POST['username'] == '') {
            add_message_error('Username is required');
            reload_page();
            exit;
        }
        if($_POST['password'] == '') {
            add_message_error('Password is required');
            reload_page();
            exit;
        }
        $login = login($_POST['username'], $_POST['password']);
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
    <title>Login | Lemon Squeeze Inventory System</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="css/login.css" type="text/css" rel="stylesheet">
</head>

<body>
    <div class="banner-container">
        <div class="banner">
            <div class="logo1">
                <img src="assets/images/LOGO1.png" alt="LemonSqueeze" width="350px">
            </div>
            <div class="text">
                <p>Inventory System</p>
            </div>
            <div class="logo2">
                <img src="assets/images/LOGO2.png" alt="LemonSqueeze" width="350px">
            </div>
        </div>
    </div>
    <section class="box">
        <form action="login.php" method="post">
            <h3>LOGIN</h3>
            <table>
                <tr class="center">
                    <td class="user">Username</td>
                </tr>
                <tr class="center">
                    <td>
                        <input type="text" name="username" placeholder="Username">
                    </td>
                </tr>
                <tr class="center">
                    <td class="user-pass">Password</td>
                </tr>
                <tr class="center">
                    <td>
                        <input type="password" name="password" placeholder="********">
                    </td>
                </tr>
                <tr>
                    <td class="register-link">
                        Not Registered?<a href="register.php"> Click Here</a>
                    </td>
                    <td class="button-login">
                        <button type="submit" name="submit">LOGIN</button>
                    </td>
                </tr>
            </table>
        </form>
    </section>
</body>

<footer>
    <br><br>
</footer>

</html>