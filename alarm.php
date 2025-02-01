<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

if (!isset($_SESSION['auth'])) {
    header('Location: index.php');
    exit; // Ensure script execution stops after redirect
}

include('Action/db_connection.php'); // Include database connection

$email = $_SESSION["user"];
$sql = "SELECT * FROM alarms ORDER BY Date DESC LIMIT 100"; // Limiting results to 100 rows
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="' . $row['Priority'] . '">';
        echo '<td>' . $row['Date'] . '</td>';
        echo '<td>' . $row['Message'] . '</td>';
        echo '<td>' . $row['Priority'] . '</td>';
        echo '<td>' . $row['Occurrences'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">No data found in the table.</td></tr>';
}

$con->close(); // Close the database connection
?>

