<?php
// Establish a database connection (replace with your own credentials).
$conn = mysqli_connect("127.0.0.1", "jahaann", "Jahaann#321", "haleeb");

// Check for a successful connection.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the record ID from the POST request.
$recordId = $_POST["recordId"];

// Update the value in the database.
$sql = "UPDATE blink SET alert = 'off' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $recordId);
$stmt->execute();

// Close the database connection.
$stmt->close();
$conn->close();

// Send a response back to the JavaScript function (optional).
echo "Update successful!";
?>