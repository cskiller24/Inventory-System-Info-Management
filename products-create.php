<?php
    require 'core/functions.php';
    redirect_if_not_authenticated('login');

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $validated = validate([
            'name' => ['required', 'string'],
            'quantity' => ['required', 'int'],
            'buying_price' => ['required', 'float'],
            'selling_price' => ['required', 'float'],
        ], $_POST);

        if(!$validated) {
            redirect('home');
            exit;
        } else {
            extract($_POST);

            $product_image = save_image($_FILES['image']);
            // if (!$product_image) reload_page();
            $product = sql_insert(
                PRODUCTS_TABLE,
                [
                    'name' => $name,
                    'quantity' => $quantity,
                    'buying_price' => $buying_price,
                    'selling_price' => $selling_price,
                    'image' => $product_image
                ]
            );

            if($product) {
                add_message_success('Product added successfully');
                redirect('home');
            } else {
                add_message_success('Something went wrong please try again');
                remove_image($product_image);
            }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/products-create.css" type="text/css" rel="stylesheet">
    <title>Products Create | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <div class="contents">
        <div class="main-contents">
            <div class="dot-logo">
                <img src="assets/images/dot-logo.png" alt="dot-logo" width="35px">
                <div class="h1-style">
                    <h1>ADD NEW PRODUCT</h1>
                </div>
            </div>
            <hr>
            <div class="addproducts-input">
                <form method="post" enctype="multipart/form-data">
                    <div class="input-icons">
                        <div class="vl"></div>
                        <i id="first" class="fa fa-circle icon"></i>
                        <i id="second" class="fa fa-circle icon"></i>
                        <i id="third" class="fa fa-circle icon"></i>
                        <input class="flavor" type="text" name="name" placeholder="PRODUCT FLAVOR" required>
                        <div class="vl2"></div>
                        <i class="fa fa-shopping-cart icon fa-2x"></i>
                        <input class="quantity" type="tel" name="quantity" placeholder="QUANTITY" required>
                        <div class="vl3"></div>
                        <div class="peso-sign">&#8369;</div>
                        <input class="buying-price" type="tel" name="buying_price" placeholder="BUYING PRICE" required>
                        <div class="vl4"></div>
                        <div class="peso-sign2">&#8369;</div>
                        <input class="selling-price" type="tel" name="selling_price" placeholder="SELLING PRICE"
                            required>
                        <div class="vl5"></div>
                        <i class="fa fa-file-image-o fa-2x"></i>
                        <input class="product-image" type="file" name="image" required>
                        <input class="btn" type="submit" value="ADD PRODUCT" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>