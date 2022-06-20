<?php
    declare(strict_types=1);
    require 'connection.php';
    session_start();

    /**
     * Redirect user to homepage
     *
     * @param string $url
     * @param integer $status_code
     * @return void
     */
    function redirect(string $url, int $status_code = 301): void
    {
        if(substr($url, -4) === '.php') {
            header("Location: {$url}", false, $status_code);
        } else {
            header("Location: {$url}.php", false, $status_code);
        }

        exit();
    }

    /**
     * Reload page for the user
     *
     * @return void
     */
    function reload_page(): void
    {
        header("Refresh: 0");
        exit;
    }

    /**
     * Redirect if authenticated
     *
     * @param string $url
     * @return void
     */
    function redirect_if_authenticated(string $url): void
    {
        if(is_authenticated() === true){
            redirect($url);
        }
    }

    /**
     * Redirect if not authenticated
     *
     * @param string $url
     * @return void
     */
    function redirect_if_not_authenticated(string $url): void
    {
        if(is_authenticated() === false){
            redirect($url);
        }
    }

    /**
     * Set message to the frontend
     *
     * @param string $key
     * @param string $message
     * @return void
     */
    function add_message(string $key, string $message): void
    {
        $_SESSION['message'][$key] = $message;
    }

    /**
     * Add success mesasge
     *
     * @param string $message
     * @return void
     */
    function add_message_success(string $message): void
    {
        add_message('success', $message);
    }

    /**
     * Add error message
     *
     * @param string $message
     * @return void
     */
    function add_message_error(string $message) : void
    {
        add_message('error', $message);
    }

    /**
     * Display message
     *
     * @param string $key
     * @return string
     */
    function display_message(string $key): string
    {
        if(! isset($_SESSION['message'][$key])) {
            return 'test';
        }
        
        return $_SESSION['message'][$key];
    }

    /**
     * Display message but 
     * once it is called it will automatically delete it
     *
     * @param string $key
     * @return string
     */
    function flash_message(string $key): string
    {
        if(! isset($_SESSION['message'][$key])) {
            return '';
        }
        
        $message = $_SESSION['message'][$key];

        unset($_SESSION['message'][$key]);

        return $message;
    }

    /**
     * Flash success message
     *
     * @return string
     */
    function flash_message_success(): string
    {
        return flash_message('success');
    }

    /**
     * Flash error message 
     *
     * @return string
     */
    function flash_message_error(): string
    {
        return flash_message('error');
    }        

    /**
     * Get all messages
     *
     * @return array
     */
    function get_all_messages(): array
    {
        return $_SESSION['message'] ?? [];
    }
    
    /**
     * Insert row in a database
     *
     * @param string $table
     * @param array $data
     * @return bool
     */
    function sql_insert(string $table, array $data): bool
    {
        global $connection;

        $columns = [];
        $values = [];

        foreach ($data as $column => $value) {
            if(! is_int($value)) {
                $value = escape($value);
            }

            $columns[] = "`$column`";
            $values[] = "'$value'";
        }   

        $string_columns = "(".implode(', ', $columns).")";
        $string_values = "(".implode(', ', $values).")";

        $sql = "INSERT INTO `{$table}` {$string_columns} VALUES {$string_values}";
        
        return mysqli_query($connection, $sql);
    }

    /**
     * Get database columns and data
     *
     * @param string $table
     * @param string $columns
     * @param array $where
     * @return array|boolean
     */
    function sql_select(string $table, array|string $columns, array $where = [], int $limit = 0): array|bool
    {
        global $connection;

        if(is_array($columns)) {
            $columns = implode(', ', $columns);
        }
        
        $sql = "SELECT {$columns} FROM {$table}";

        if($where) {
            foreach ($where as $column => $value) {
                if(! is_int($value)) {
                    $value = escape($value);
                }
                $where_array[] = "`{$column}`='{$value}'"; 
            }
            $sql .= " WHERE ".implode(" and ", $where_array);
        }

        if($limit !== 0) $sql .= " LIMIT {$limit}";

        $query = mysqli_query($connection, $sql);

        if($query && mysqli_num_rows($query) > 0) {
            return mysqli_fetch_all($query, MYSQLI_ASSOC);
        }

        return false;
    }

    /**
     * Update row/s in table
     *
     * @param string $table
     * @param array $data
     * @param array $where
     * @return boolean
     */
    function sql_update(string $table, array $data, array $where = []): bool
    {
        global $connection;

        $newData = [];
        foreach ($data as $column => $value) {
            $newData[] = "`{$column}` = '{$value}'";
        }

        $sql = "UPDATE `{$table}` SET ".implode(', ', $newData);

        if ($where) {
            foreach ($where as $column => $value) {
                if(! is_int($value)) {
                    $value = escape($value);
                }
                $where_array[] = "`{$column}`='{$value}'"; 
            }
            $sql .= " WHERE ".implode(" and ", $where_array);
        }

        return mysqli_query($connection, $sql);
    }

    /**
     * Delete row/s in a table
     *
     * @param string $table
     * @param array $where
     * @return boolean
     */
    function sql_delete(string $table, array $where): bool
    {
        global $connection; 
        $where_array = [];
        foreach ($where as $column => $value) {
            $where_array[] = "`{$column}`='{$value}'";
        }
        $sql = "DELETE FROM `{$table}` WHERE ".implode(" and ", $where_array);

        return mysqli_query($connection, $sql);
    }

    
    /**
     * Check if a value in a table exists
     *
     * @param string $table
     * @param string $column
     * @param string $value
     * @return boolean
     */
    function sql_exists(string $table, string $column, string $value): bool
    {
        $data = sql_select($table, '*', [$column => $value]);
        return (bool) $data;
    }

    /**
     * Find data by id
     *
     * @param string $table
     * @param string|integer $id
     * @return array|boolean
     */
    function sql_find_by_id(string $table, string|int $id): array|bool
    {
        return sql_select($table, '*', ['id' => $id], 1);
    }

    /**
     * Prevent sql injections
     *
     * @param string $data
     * @return string
     */
    function escape(string $data): string
    {
        global $connection;

        return mysqli_escape_string($connection, $data);
    }

    /**
     * Login a user
     *
     * @param string $username
     * @param string $password
     * @return array
     */
    function login(string $username, string $password): array
    {
        $email = escape($username);

        $data = sql_select(USERS_TABLE, '*', ['username' => $username])[0];

        if(! $data) 
            return ['status' => false, 'message' => 'Username does not exists'];

        if(! password_verify($password, $data['password'])) 
            return ['status' => false, 'message' => 'Password does not match'];

        authenticate($data);

        return ['status' => true, 'message' => 'Successfully Logged In'];
    }

    /**
     * Register a user
     *
     * @param array $data
     * @return array
     */
    function register(array $data): array
    {
        global $connection;

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if(sql_exists(USERS_TABLE, 'email', $data['username'])) {
            return [
                'status' => false,
                'message' => 'Username exists in the database'
            ];
        }

        if(! sql_insert(USERS_TABLE, $data)) {
            return [
                'status' => false, 
                'message' => 'Error in register in user', 
                'sql_error' => mysqli_error($connection)
            ];
        }

        return ['status' => true, 'message' => 'Successfully Registered User'];
    }

    function logout(): bool
    {
        if(!is_authenticated()) return false;
        return session_destroy();
    }
    /**
     * Check if the user is logged in 
     *
     * @return boolean
     */
    function is_authenticated(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Login the user in session
     *
     * @param array $data
     * @return void
     */
    function authenticate(array $data): void
    {
        $_SESSION['user'] = $data;
    }

    /**
     * Get the authenticated user data
     *
     * @return array
     */
    function get_authenticated_user(): array
    {
        return $_SESSION['user'] ?? [];
    }

    /**
     * Custom sql query for finding all sales by dates
     *
     * @param [type] $start_date
     * @param [type] $end_date
     * @return array
     */
    function get_sale_by_dates($start_date, $end_date)
    {
        global $connection;
        $start_date  = date("Y-m-d", strtotime($start_date));
        $end_date    = date("Y-m-d", strtotime($end_date));
        $sql  = "SELECT s.date_added, p.name,p.selling_price,p.buying_price,";
        $sql .= "COUNT(s.product_id) AS total_records,";
        $sql .= "SUM(s.quantity) AS total_sales,";
        $sql .= "SUM(p.selling_price * s.quantity) AS total_selling_price,";
        $sql .= "SUM(p.buying_price * s.quantity) AS total_buying_price ";
        $sql .= "FROM sales s ";
        $sql .= "LEFT JOIN products p ON s.product_id = p.id";
        $sql .= " WHERE s.date_added BETWEEN '{$start_date}' AND '{$end_date}'";
        $sql .= " GROUP BY DATE(s.date_added),p.name";
        $sql .= " ORDER BY DATE(s.date_added) DESC";
        $result = mysqli_query($connection, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_sales_by_dates_with_calculations($start_date, $end_date)
    {
        $products = get_sale_by_dates($start_date, $end_date);

        $buying_total = 0;
        $selling_total = 0;
        foreach($products as $product) {
            $buying_total += $product['total_buying_price'];
            $selling_total += $product['total_selling_price'];
        }
        $products['grand_total'] = $selling_total;
        $products['profit'] = $selling_total - $buying_total;

        return $products;
    }

    /**
     * Check for validation on a POST request
     *
     * Example parameters can be pass 
     * ['name' => $_POST['name'], 'email' => $_POST['email']]
     *
     * @param array $data
     * @param array $payloads
     * @return false
     */
    function validate(array $data, array $payloads): bool
    {
        foreach ($data as $key => $rules) {
            if (! array_key_exists($key, $payloads)) {
                add_message_error($key.' does not exists on $_POST request');
                return false;
            }
            if (in_array('required', $rules) && $payloads[$key] == '') {
                add_message_error($key. ' is required.');
                return false;
            }
            if (in_array('string', $rules) && ! is_string($payloads[$key])) {
                add_message_error($key. ' must be a string.');
                return false;
            }
            if (in_array('int', $rules) && ! filter_var($payloads[$key], FILTER_VALIDATE_INT) ) {
                add_message_error($key. ' must be an integer');
                return false;
            }
            if (in_array('float', $rules) && ! filter_var($payloads[$key], FILTER_VALIDATE_FLOAT)) {
                add_message_error($key.' must be a float');
                return false;
            }
        }
        return true;
    }

    /**
     * Save image to the images folder
     *
     * @param array $files
     * @param string $image_path
     * @return boolean|string
     */
    function save_image(array $files, string $image_path = 'images/'): bool|string
    {
        $tempFileExtension = explode('.', $files['name']);
        $fileExtension = strtolower(end($tempFileExtension));

        if(!in_array($fileExtension, ALLOWED_IMAGE_TYPES)) {
            add_message('image', 'Invalid file type');
            return false;
        }

        if($files['error'] !== 0) {
            add_message('image', 'Something went wrong please try again');
            return false;
        }

        $fileName = md5(uniqid('', true)).'.'.$fileExtension;
        if(!move_uploaded_file($files['tmp_name'], $image_path.$fileName)){
            add_message('image', 'Something went wrong please try again');
            return false;
        }
        
        return $fileName;
    }

    /**
     * Remove an image to the image folder
     *
     * @param string $fileName
     * @param string $image_path
     * @return boolean
     */
    function remove_image(string $fileName, string $image_path = 'images/'): bool
    {
        return unlink($image_path.$fileName);
    }

    /**
     * Get the filename of which this function called
     * if compare is set, it will return boolean
     *
     * @param string $compare
     * @return string|bool
     */
    function get_filename(string $compare = ''): bool
    {
        if($compare !== '') {
            $data = explode('/',$_SERVER['PHP_SELF']);
            $array = end($data) === $compare;
            return $array;
        }
        return false;
    }