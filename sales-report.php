<?php
    require 'core/functions.php';
    redirect_if_not_authenticated('login');

    if(isset($_GET['start-date']) && isset($_GET['end-date'])) {
        $sales = get_sales_by_dates_with_calculations($_GET['start-date'], $_GET['end-date']);
        $profit = $sales['profit'];
        $grand_total = $sales['grand_total'];
        unset($sales['profit']);
        unset($sales['grand_total']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="css/sales-report.css">
    <title>Sales Report | Lemon Squeeze Inventory System</title>
</head>

<body>
    <?php include 'layouts/sidebar.php' ?>
    <?php include 'layouts/messages.php' ?>
    <div class="contents">
        <div class="main-contents">
            <?php if(!isset($_GET['start-date']) || !isset($_GET['end-date'])): ?>
            <div class="input-form">
                <form method="get">
                    <table>
                        <thead>
                            <th>
                                Start Date
                            </th>
                            <th>
                                End Date
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="date" name="start-date" />
                                </td>
                                <td>
                                    <input type="date" name="end-date" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Get Report">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <?php endif ?>
            <?php if(isset($_GET['start-date']) && isset($_GET['end-date'])): ?>
            <?php if($sales): ?>
            <h1>Sales Report</h1>
            <div class="sales-form">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product Name</th>
                            <th>Buying Price</th>
                            <th>Selling Price</th>
                            <th>Total Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sales as $sale): ?>
                        <tr>
                            <td><?= $sale['date_added'] ?></td>
                            <td><?= $sale['name'] ?></td>
                            <td><?= $sale['buying_price'] ?></td>
                            <td><?= $sale['selling_price'] ?></td>
                            <td><?= $sale['total_sales'] ?></td>
                            <td><?= $sale['total_selling_price'] ?></td>
                        </tr>
                        <?php endforeach ?>
                        <tr>
                            <td colspan="5">Grand Total</td>
                            <td><?= number_format($grand_total, 2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="5">Profit</td>
                            <td><?= number_format($profit, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <h1>Sales with the selected date does not exists</h1>
            <?php endif ?>
            <?php endif ?>
        </div>
    </div>

</body>

</html>