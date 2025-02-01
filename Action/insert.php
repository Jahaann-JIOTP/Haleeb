<?php
session_start();
include('db_connection.php');
 $UserName=$_POST['name'];
 $Email=$_POST['email'];
 $Password=$_POST['password'];
 $usertype=$_POST['type'];
 $userlevel=$_POST['level'];

//   converting arry in the coma seperated string
 $userLevelString = implode(',', $usertype);
//  end


    $sql = "SELECT * FROM accounts  WHERE email = '$Email'";
    $result = mysqli_query($con, $sql);

    //    echo "this is a test data";
if (mysqli_num_rows($result)>0)
{

$_SESSION['registered']="Email already registered";
	header('location:../home.php');

}
else{
$sql = "INSERT INTO accounts (name, email, pass, user_level, status ) VALUES ('$UserName', '$Email', '$Password' , '$userLevelString' , '$userlevel')";
$_SESSION['registered']="successfully registered";
$_SESSION['id'] =  $row["id"];
	header('location:../home.php');
}
if(mysqli_query($con, $sql)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}
 
// Close connection
mysqli_close($con);
?>



<!-- 
$userLevels = $_POST['user_level'];

// Convert the array into a comma-separated string
$userLevelString = implode(',', $userLevels);

// Use the $userLevelString in your SQL query to insert into the 'user_level' column

// Example usage in your SQL query:
$query = "INSERT INTO accounts (name, email, pass, user_level, status) VALUES ('$UserName', '$Email', '$Password',
'$userLevelString', '$usertype')"; -->