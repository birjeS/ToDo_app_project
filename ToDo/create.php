<?php
include 'db.php';
session_start();

// Create connection
$conn = createDatabaseConnection();

// Check if the 'tasks' table exists and create it if not
createTasksTable($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskName = $_POST['task_name'];
    $userId = $_SESSION['user_id'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO tasks (task_name, completed, user_id) VALUES (?, 0, ?)");
    $stmt->bind_param("si", $taskName, $userId);

    if ($stmt->execute()) {
        // Task added successfully, redirect to tasks.php
        header("Location: tasks.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a New Task</title>
    <link rel="stylesheet" href="../welcome.css"> <!-- Add your CSS file -->
</head>

<body>

<div class="container">
    <h1>Create a New Task</h1>

    <form action="create.php" method="post"> <!-- Update the action attribute -->
        <label for="task_name">Task Name:</label>
        <input type="text" name="task_name" id="task_name" required>
        <button type="submit">Add Task</button>
    </form>

    <!-- Add any additional content or styling as needed -->

</div>

</body>

</html>
