<?php
include 'db.php';
session_start();

// Create connection
$conn = createDatabaseConnection();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login&Register/login.php");
    exit();
}

// Function to create 'tasks' table if not exists
createTasksTable($conn);

// Function to get tasks for the current user
function getTasks($connection, $userId) {
    $sql = "SELECT * FROM tasks WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $result = $stmt->get_result();

    return ($result->num_rows > 0) ? $result : false;
}

// Get user ID from the session
$userId = $_SESSION['user_id'];

// Get tasks for the user
$tasks = getTasks($conn, $userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Tasks</title>
    <link rel="stylesheet" href="../tasks.css">
</head>

<body>
<div class="container">
    <h1>Your Tasks</h1>

    <?php
    if ($tasks !== false) {
        while ($task = $tasks->fetch_assoc()) {
            echo "<div class='task-item" . ($task['completed'] ? ' completed' : '') . "'>";
            echo "Task: " . htmlspecialchars($task["task_name"]) . " - Completed: ";
            echo "<span class='status'>" . ($task['completed'] ? 'Finished' : 'Unfinished') . "</span>";
            echo "<button class='edit-task' data-task-id='" . $task['id'] . "'>Edit</button>";
            echo "<button class='delete-task' data-task-id='" . $task['id'] . "'>Delete</button>";
            echo "</div>";
        }
    } else {
        echo "<p>No tasks found.</p>";
    }
    ?>

    <!-- Add your HTML and PHP code here -->
</div>

<!-- Add your script tags for task-related functionality -->
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
