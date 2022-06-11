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
    <link rel="stylesheet" href="css/products-create.css">
    <title>Products Create | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <div class="contents">
        <div class="main-contents">
            <!-- <form method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Flavor" required>
                <input type="tel" name="quantity" placeholder="Quantity" required>
                <input type="tel" name="buying_price" placeholder="Buying Price" required>
                <input type="tel" name="selling_price" placeholder="Selling Price" required>
                <input type="file" name="image" placeholder="Image" required>
                <input type="submit" value="Submit" name="submit">
            </form> -->
            <div class="box">
                <h1>ADD NEW PRODUCT</h1>
                <hr>
                <div class="create-form">
                    <form method="post" enctype="multipart/form-data">
                        <div class="product-flavor">
                            <div class="input-group">
                                <div class="input-group-icon">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </div>
                                <div class="input-group-area">
                                    <input type="text" placeholder="Flavor" name="name">
                                </div>
                            </div>
                        </div>
                        <div class="forms-below">
                            <div class="quantity">
                                <div class="input-group">
                                    <div class="input-group-icon">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </div>
                                    <div class="input-group-area">
                                        <input type="tel" placeholder="Quantity" name="quantity" required>
                                    </div>
                                </div>
                            </div>

                            <div class="buying-price">
                                <div class="input-group">
                                    <div class="input-group-icon">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </div>
                                    <div class="input-group-area">
                                        <input type="tel" placeholder="Buying Price" name="buying_price" required>
                                    </div>
                                </div>
                            </div>

                            <div class="selling-price">
                                <div class="input-group">
                                    <div class="input-group-icon">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </div>
                                    <div class="input-group-area">
                                        <input type="tel" placeholder="Selling Price" name="selling_price" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="file">
                            <label for='input-file'>
                                Image
                            </label>
                            <input id="input-file" type="file" name="image" required />
                        </div>

                        <div class="submit-button">
                            <input type="submit" value="Submit" name="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>