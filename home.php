<?php 
    require 'core/functions.php';
    redirect_if_not_authenticated('login');

    $products = sql_select(PRODUCTS_TABLE, '*');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home | Lemon Squeeze Inventory System</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <div class="contents">
        <div class="main-contents">
            <?php include_once 'layouts/messages.php' ?>
            <?php if($products): ?>

            <div class="products">
                <?php foreach($products as $product): ?>
                <div class="card">
                    <div class="image">
                        <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?> Image">
                    </div>
                    <div class="product-text">
                        <div class="name">
                            <?= $product['name'] ?>
                        </div>
                        <div class="price">
                            $ <?= $product['selling_price'] ?>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>

            <?php else: ?>
            <div class="_404">
                <h1>No Products</h1>
            </div>
            <?php endif ?>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>