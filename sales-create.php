<?php
    require 'core/functions.php';
    redirect_if_not_authenticated('login');

    $products = sql_select(PRODUCTS_TABLE, '*');
    $date_today = date('Y-m-d');

    if(isset($_GET['product_id'])) {
        $product = sql_find_by_id(PRODUCTS_TABLE, $_GET['product_id'])[0] ?? false;
    }

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $validate = validate([
            'product_id' => ['required'],
            'total' => ['required', 'float'],
            'quantity' => ['required', 'int']
        ], $_POST);
        if(! $validate) {
            redirect('home');
        }
        // Mysql transaction for consistency
        global $connection;
        mysqli_autocommit($connection, false);
        extract($_POST);
        $sales = sql_insert(SALES_TABLE, [
            'name' => $name, 
            'product_id' => $product_id,
            'price' => $price,
            'quantity' => $quantity,
            'total' => $total,
            'date_added' => $date_added
        ]);

        if($product_quantity - $quantity < 0 ) {
            add_message_error('Quantity you selected is not enough in stock');
            redirect('home');
        }
        $product_update =1 ;

        if(!$sales) {
            add_message_error('Error on adding sales, please try again');
        } else {
            add_message_success('Sales Added Successfully');
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
    <link rel="stylesheet" href="css/sales-create.css">
    <title>Sales Create | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <?php include 'layouts/messages.php' ?>
    <div class="contents">
        <div class="main-contents">
            <?php if($products): ?>
            <?php if(! isset($_GET['product_id'])): ?>
            <div class="product-select">
                <h1>Select Product you want to add sale</h1>
                <form action="" method="get">
                    <select name="product_id">
                        <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <input type="submit" value="Select">
                </form>
            </div>

            <?php else: ?>
            <?php if ($product): ?>
            <div class="sale-add">
                <form method="post">
                    <table>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td><?= $product['name'] ?></td>
                            </tr>
                            <tr>
                                <td>In Stock</td>
                                <td><?= $product['quantity'] ?></td>
                            </tr>
                            <tr>
                                <td>Selling Price</td>
                                <td><?= $product['selling_price'] ?></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>
                                    <p id="total_display">0</p>
                                </td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td>
                                    <input type="number" name="quantity" id="quantity" min="1"
                                        max="<?= $product['quantity'] ?>" onchange="update_total(event)">
                                </td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>
                                    <input type="date" name="date_added" value="<?= $date_today ?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="price" id="price" value="<?= $product['selling_price'] ?>">
                    <input type="hidden" name="product_quantity" value="<?= $product['quantity'] ?>">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="total" id="total">
                    <input type="hidden" name="name" value="<?= $product['name'] ?>">
                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>
            <?php else: ?>
            <div class="_404">
                <h1>Product does not exists</h1>
                <a href="sales-create.php">Reset</a>
            </div>
            <?php endif ?>
            <?php endif ?>
            <?php else: ?>
            <div class="h1">No Products</div>
            <?php endif ?>
        </div>
    </div>

    <script>
    let totalDisplay = document.getElementById("total_display")
    let sellingPrice = document.getElementById("price")
    let totalInput = document.getElementById("total")

    function update_total(event) {
        let inputQuantity = document.getElementById("quantity")
        totalDisplay.innerHTML = inputQuantity.value * sellingPrice.value
        totalInput.value = inputQuantity.value * sellingPrice.value
    }
    </script>
</body>

</html>