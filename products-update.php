<?php
    require 'core/functions.php';
    redirect_if_not_authenticated('login');
    
    $product = false;
    if(isset($_GET['id'])) {
        $product = sql_find_by_id(PRODUCTS_TABLE, $_GET['id'])[0] ?? false;
    }

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $validate = validate([
            'name' => ['required', 'string'],
            'quantity' => ['required', 'int'],
            'buying_price' => ['required', 'float'],
            'selling_price' => ['required', 'float'],
        ], $_POST);

        if(! $validate) {
            redirect('home');
        }
        extract($_POST);
        $pictureEdit = false;
        $imageName = false;
        if($_FILES['image']['error'] === 0) {
            $pictureEdit = true;
            $imageName = save_image($_FILES['image']);
        }
        
        if($pictureEdit) {
            if(! $imageName) redirect('home');

            remove_image($current_image);

            $product = sql_update(
                    'products',
                    [
                        'name' => $name,
                        'quantity' => $quantity,
                        'buying_price' => $buying_price,
                        'selling_price' => $selling_price,
                        'image' => $imageName
                    ],
                    [
                        'id' => $id
                    ]
                );
        }

        if(! $pictureEdit) {
            $product = sql_update(
                    'products',
                    [
                        'name' => $name,
                        'quantity' => $quantity,
                        'buying_price' => $buying_price,
                        'selling_price' => $selling_price,
                    ],
                    [
                        'id' => $id
                    ]
                );
        }
            
        if($product) {
            add_message('success', 'Product update successfully');
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
    <link rel="stylesheet" href="css/products-update.css">
    <title>Products Update | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php'?>
    <?php include 'layouts/messages.php'?>
    <div class="contents">
        <div class="main-contents">
            <?php if($product): ?>
            <div class="card p-3">
                <!-- <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="current_image" value="<?= $product['image'] ?>">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <input type="text" name="name" placeholder="Flavor" value="<?= $product['name'] ?>" required>
                    <input type="tel" name="quantity" placeholder="Quantity" value="<?= $product['quantity'] ?>"
                        required>
                    <input type="tel" name="buying_price" placeholder="Buying Price"
                        value="<?= $product['buying_price'] ?>" required>
                    <input type="tel" name="selling_price" placeholder="Selling Price"
                        value="<?= $product['selling_price'] ?>" required>
                    <?php if($product['image']): ?>
                    <img src="images/<?= $product['image'] ?>" id="previewFrame">
                    <?php endif ?>
                    <input type="file" name="image" placeholder="Image" id="tmp" onchange="previewImage(event)">
                    <input type="submit" value="Submit" class="btn btn-primary" name="submit">
                </form> -->
                <form method="post" enctype="multipart/form-data">
                    <div class="main-form">
                        <div class="image-section">
                            <div class="input-images">
                                <div class="file">
                                    <label for="input-file">
                                        Click here to Upload Image Here
                                    </label>
                                    <input type="file" id="input-file" name="image" placeholder="Image" id="tmp"
                                        onchange="previewImage(event)">
                                </div>
                                <img src="images/<?= $product['image'] ?>" id="previewFrame">
                            </div>
                        </div>
                        <div class="input-section">
                            <div class="input-text">
                                <label for="flavor">Product Flavor</label>
                                <input type="text" name="name" placeholder="Flavor" value="<?= $product['name'] ?>"
                                    required>
                            </div>
                            <div class="input-text">
                                <label for="quantity">Quantity</label>
                                <input type="tel" name="quantity" placeholder="Quantity"
                                    value="<?= $product['quantity'] ?>" required>
                            </div>
                            <div class="input-text">
                                <label for="selling-price">Buying Price</label>
                                <input type="tel" name="buying_price" placeholder="Buying Price"
                                    value="<?= $product['buying_price'] ?>" required>
                            </div>
                            <div class="input-text">
                                <label for="selling-price">Selling Price</label>
                                <input type="tel" name="selling_price" placeholder="Selling Price"
                                    value="<?= $product['selling_price'] ?>" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="current_image" value="<?= $product['image'] ?>">

                    <div class="submit-button">
                        <input type="submit" value="Update Product" class="btn btn-primary" name="submit">
                    </div>
                </form>
            </div>
            <?php else: ?>
            <div class="_404">
                <h1 style="text-align: center;">404 Not Found - Product with id of <?= $_GET['id'] ?> does not exists
                </h1>
                <br>
                <a href="products-manage.php">Return</a>
            </div>

            <?php endif ?>

        </div>
    </div>
    <script type="text/javascript">
    function previewImage(event) {
        if (event.target.files.length > 0) {
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("previewFrame");
            preview.src = src;
            preview.style.display = "block";
        }
    }
    </script>
</body>

</html>