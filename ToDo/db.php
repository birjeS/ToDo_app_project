<?php
function createDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "qwerty";
    $dbname = "task_management";

    // Check if the connection is already established
    if (!isset($GLOBALS['conn']) || $GLOBALS['conn']->connect_error) {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Store the connection in the global scope
        $GLOBALS['conn'] = $conn;
    }

    return $GLOBALS['conn'];
}

function createTasksTable($connection) {
    // Check if the 'tasks' table exists
    $tableExistsQuery = "SHOW TABLES LIKE 'tasks'";
    $tableExistsResult = $connection->query($tableExistsQuery);

    if ($tableExistsResult->num_rows == 0) {
        // 'tasks' table does not exist, create it
        $createTableQuery = "
            CREATE TABLE tasks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                task_name VARCHAR(255) NOT NULL,
                completed BOOLEAN NOT NULL,
                user_id INT NOT NULL
            )
        ";

        if ($connection->query($createTableQuery) === TRUE) {
            echo "Table 'tasks' created successfully";
        } else {
            echo "Error creating table: " . $connection->error;
        }
    }
}