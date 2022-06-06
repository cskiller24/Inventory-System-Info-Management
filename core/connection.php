<?php
    declare(strict_types=1);
    include 'config.php';

    $connection = mysqli_connect(
        DB_HOST,
        DB_USERNAME,
        DB_PASSWORD,
        DB_DATABASE
    );

    if(! $connection) {
        die(mysqli_connect_error());
    }