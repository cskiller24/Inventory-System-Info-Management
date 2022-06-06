<?php
    declare(strict_types=1);

    // Define sql connection
    const DB_DATABASE = 'inventory_management';
    const DB_HOST = 'localhost';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';
    const DB_PORT = 3306;

    $root = basename(__DIR__);
    // Define pages directory
    const PAGES_LOCATION = DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR; // Same as "src/pages/"

    const SERVICES_LOCATION = DIRECTORY_SEPARATOR."services".DIRECTORY_SEPARATOR; // Same as "src/services/"

    // Define users table in sql
    const USER_TABLE = 'users';

    const ALLOWED_IMAGE_TYPES = ['jpg', 'png', 'jpeg'];
