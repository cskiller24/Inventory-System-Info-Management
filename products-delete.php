<?php
    require 'core/functions.php';
    redirect_if_not_authenticated('login');
    $product = false;
    if(isset($_GET['id'])) {
        $product = sql_find_by_id(PRODUCTS_TABLE, $_GET['id'])[0];
    }
    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (! sql_exists(PRODUCTS_TABLE, 'id', $id)) {
            add_message_error('Product with the id of '. $id . 'does not exists');
            redirect('login');
        }
        if (sql_delete('products', ['id' => $id]) && remove_image($image)) {
            add_message_success('Successfully delete product');
        } else {
            add_message_error('Something went wrong in deleting product');
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
    <title>Products Delete | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <div class="contents">
        <div class="main-contents">
            <?php if($product): ?>
            <form method="post">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <input type="hidden" name="image" value="<?= $product['image'] ?>">
                <input type="submit" value="Confirm delete? <?= $product['name'] ?>" name="submit">
            </form>
            <?php else: ?>
            <h1>404 Not Found - Product with id of <?= $_GET['id'] ?> does not exists</h1>
            <?php endif ?>
        </div>
    </div>

</body>

</html>