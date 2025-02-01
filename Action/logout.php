<?php
session_start();
if (!isset($_SESSION['auth'])) {
    // not logged in
    header('Location: ../index.php');
    exit; // Terminate the script to ensure immediate redirection
}

// Destroy the session

session_destroy();
// Display a logout message (optional)


// Redirect to the desired location
$URL = "../index.php";
echo "<script>location.href='$URL'</script>";

?>
