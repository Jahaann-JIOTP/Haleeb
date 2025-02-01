<?php
// Enable error reporting and display errors during development
error_reporting(E_ALL);
ini_set('display_errors', 1); 

include('db_connection.php');
session_start();

$email = $_POST['email']; 
$pass = $_POST['password'];

// Prepare the query using prepared statements
$stmt = mysqli_prepare($con, "SELECT * FROM accounts WHERE email = ?"); 
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);

  // Verify the password
  if ($pass == $row['pass']) {
    // Password is correct
    $_SESSION["auth"] = $row["id"];
    $_SESSION["user"] = $email;
    $_SESSION["stat"] = $row["status"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["user_level"] = $row["user_level"];
    $_SESSION["on"] = "Login Successfully";
    header('location:../home.php');
    exit();
  }
}

// Invalid email/password
$_SESSION["in"] = "Invalid email/Password";
header("location:../index.php");
exit();
?>