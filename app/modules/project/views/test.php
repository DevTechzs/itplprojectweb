<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $taskTitle = $_POST["task-title"];
    $taskDescription = $_POST["task-description"];
    $assignedTo = $_POST["assigned-to"];
    $priority = $_POST["priority"];
    $dueDate = $_POST["due-date"];

    // Process uploaded files
    $attachments = $_FILES["attachments"];
    // Handle the uploaded files as needed

    // Display the data
    echo "<h2>Task Details</h2>";
    echo "<p><strong>Task Title:</strong> $taskTitle</p>";
    echo "<p><strong>Task Description:</strong> $taskDescription</p>";
    echo "<p><strong>Assigned To:</strong> " . implode(", ", $assignedTo) . "</p>";
    echo "<p><strong>Priority:</strong> $priority</p>";
    echo "<p><strong>Due Date:</strong> $dueDate</p>";

    // Display uploaded file details
    echo "<h3>Attachments</h3>";
    foreach ($attachments["name"] as $key => $name) {
        echo "<p><strong>File $key:</strong> $name</p>";
    }
}