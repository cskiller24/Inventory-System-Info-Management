<?php 
    require 'core/functions.php';
    redirect_if_not_authenticated('login');
    $sales = sql_select(SALES_TABLE, '*');
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Manage | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <?php include 'layouts/messages.php' ?>
    <div class="contents">
        <div class="main-contents">
            <?php if($sales): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $sale): ?>
                    <tr>
                        <th scope="row"><?= $sale['product_id'] ?? 'Deleted' ?></th>
                        <td><?= $sale['name'] ?></td>
                        <td><?= $sale['quantity'] ?></td>
                        <td><?= $sale['total'] ?></td>
                        <td><?= $sale['date_added'] ?></td>
                        <td>
                            <a href="
                                <?= 'sales-delete.php?'.http_build_query(['id' => $sale['id']]) ?>
                                ">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php else: ?>
            <h1>No Sales</h1>
            <?php endif ?>
        </div>
    </div>

</body>

</html>