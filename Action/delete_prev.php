<?php
    session_start();
    // include('action.php');
    include('db_connection.php');

    // Check if the perm_id parameter is present in the URL
    if (isset($_GET['perm_id'])) {
        $perm_id = $_GET['perm_id'];

        // Perform the deletion query
        $deleteQuery = mysqli_query($con, "DELETE FROM permissions WHERE perm_id = '$perm_id'");

        // Check if the deletion was successful
        if ($deleteQuery) {
            // Redirect to a success page or perform any other desired action
            header("Location: ../home.php");
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