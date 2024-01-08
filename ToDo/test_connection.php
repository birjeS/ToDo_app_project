<?php
include 'db.php';

// Test the connection
$conn = createDatabaseConnection();
if ($conn) {
    echo "Connection successful!";
} else {
    echo "Connection failed.";
}
?>
