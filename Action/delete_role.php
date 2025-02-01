<?php
 session_start();
   
    include('db_connection.php');

    // Check if the role_id parameter is present in the URL
    if (isset($_GET['role_id'])) {
        $role_id = $_GET['role_id'];
echo  $role_id;
        // Perform the deletion query
        $deleteQuery = mysqli_query($con, "DELETE FROM roles WHERE role_id = '$role_id'");

        // Check if the deletion was successful
        if ($deleteQuery) {
            // Redirect to a success page or perform any other desired action
            header("Location:../home.php");
            exit;
        } else {
            // Redirect to an error page or display an error message
            header("Location: error.php");
            exit;
        }
    } else {
        // Redirect to an error page or display an error message
        header("Location: error.php");
        exit;
    }
?>