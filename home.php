<?php 
    require 'core/functions.php';

    redirect_if_not_authenticated('login');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Inventory Management</title>
</head>
<body>
    <?php include 'layouts/sidebar.php' ?>
    <?php include 'layouts/messages.php' ?>
</body>
</html> 