<?php
    require 'core/functions.php';
    redirect_if_not_authenticated('login');

    $sale = false;
    if(isset($_GET['id'])) {
        $sale = sql_find_by_id(SALES_TABLE, $_GET['id'])[0];
    }

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if(!sql_exists(SALES_TABLE, 'id', $_POST['id'])) {
            add_message_error('Sale does not exists');
            redirect('home');
        }
    
        if (sql_delete('sales', ['id' => $_POST['id']])) {
            add_message_success('Successfully delete sale');
        } else {
            add_message_error('Something went wrong in deleting sale');
        }
        redirect('home');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="css/sales-delete.css">
    <title>Sales Delete | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <div class="contents">
        <div class="main-contents">
            <?php if($sale): ?>
            <form method="post">
                <h1>Confirm delete <?= $sale['name'] ?> sale ?</h1>
                <input type="hidden" name="id" value="<?= $sale['id'] ?>">
                <input type="submit" value="Delete" name="submit">
            </form>
            <?php else: ?>
            <h1>Sale with id of <?= $_GET['id'] ?> does not exists</h1>
            <?php endif ?>
        </div>
    </div>
</body>

</html>