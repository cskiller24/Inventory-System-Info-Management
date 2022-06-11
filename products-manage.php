<?php
    require 'core/functions.php';

    redirect_if_not_authenticated('login');

    $products = sql_select(PRODUCTS_TABLE, '*');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="css/products-manage.css">
    <title>Products Manage | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <div class="contents">
        <div class="main-contents">
            <?php if($products): ?>
            <table>
                <thead>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>In Stock</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Product Added At</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td scope="row"><?= $product['id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td><?= $product['buying_price'] ?></td>
                        <td><?= $product['selling_price'] ?></td>
                        <td><?= $product['date_added'] ?></td>
                        <td>
                            <a href="
                                products-update.php?<?= http_build_query(['id' => $product['id']]) ?>
                                " class="update-link">
                                <i class="fa-solid fa-pen-to-square fa-2xl"></i>
                            </a>
                            <a href="
                                products-delete.php?<?= http_build_query(['id' => $product['id']]) ?>
                                " class="delete-link">
                                <i class="fa-solid fa-trash-can fa-2xl"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php else: ?>
            <h1>Products does not exists.</h1>
            <?php endif ?>
        </div>
    </div>

</body>

</html>