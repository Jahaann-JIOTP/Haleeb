<?php
  $con = mysqli_connect("15.206.128.214", "jahaann", "Jahaann#321", "haleeb");

  // Check connection
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Perform your query
  $query = "SELECT * FROM accounts";
  $result = mysqli_query($con, $query);

  if ($result) {
    // Fetch data from the result set
    while ($row = mysqli_fetch_array($result)) {
      // Process the retrieved data
      // ...
    }
  } else {
    // Display the specific query error
    die("Query error: " . mysqli_error($con));
  }
  // Close the connection
//   mysqli_close($con);
?>