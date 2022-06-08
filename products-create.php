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
            reload_page();
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
    <title>Products Create | Inventory Management</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <?php include 'layouts/messages.php' ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Flavor" required>
        <input type="tel" name="quantity" placeholder="Quantity" required>
        <input type="tel" name="buying_price" placeholder="Buying Price" required>
        <input type="tel" name="selling_price" placeholder="Selling Price" required>
        <input type="file" name="image" placeholder="Image" required>
        <input type="submit" value="Submit" name="submit">
    </form>
</body>

</html>