<?php
    declare(strict_types=1);

    // Define sql connection
    const DB_DATABASE = 'inventory_management';
    const DB_HOST = 'localhost';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';
    const DB_PORT = 3306;
    
    // Define tables as constant for consistency sql
    const USERS_TABLE = 'users';
    const PRODUCTS_TABLE = 'products';
    const SALES_TABLE = 'sales';

    const ALLOWED_IMAGE_TYPES = ['jpg', 'png', 'jpeg'];
