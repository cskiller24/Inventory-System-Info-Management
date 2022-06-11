<?php
    //Always require core/functions.php
    require 'core/functions.php';

    redirect_if_authenticated('home');

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $validate = validate([
            'name' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
            'reenter-password' => ['required'],
        ], $_POST);

        if($validate && $_POST['password'] === $_POST['reenter-password']) {
            $data = [
                'name' => $_POST['name'],
                'username' => $_POST['username'],
                'password' => $_POST['password']
            ];
            $register = register($data);
            if(! $register['status']) {
                add_message_error($register['message']);
                reload_page();
            } else {
                add_message_success($register['message']);
            }
        } else {
            add_message_error('Password does no match');
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
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <title>Register | Lemon Squeeze Inventory System</title>
    <link href="css/register.css" type="text/css" rel="stylesheet">
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
        <form action="register.php" method="post">
            <h3>SIGN-UP</h3>

            <table>
                <tr>
                    <td class="user">Name</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="name" placeholder="Name">
                    </td>
                </tr>
                <tr>
                    <td class="user">Username</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="username" placeholder="Username">
                    </td>
                </tr>
                <tr>
                    <td class="user-pass">Password</td>
                </tr>
                <tr>
                    <td>
                        <input type="password" name="password" placeholder="********">
                    </td>
                </tr>
                <tr>
                    <td class="user-pass">Re-enter Password</td>
                </tr>
                <tr>
                    <td>
                        <input type="password" name="reenter-password" placeholder="********">
                    </td>
                </tr>
                <tr>
                    <td class="login-link">
                        Already registered?<a href="login.php">Click Here</a>
                    </td>
                    <td class="button-login">
                        <button type="submit" name="submit">Sign Up</button>
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