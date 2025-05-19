<?php

                         //    Adding New Role  //
//  CHECKING SESSION
include('db_connection.php');
session_start();
if(!isset($_SESSION['auth']))
{
  // not logged in
  header('Location:index.php');
}

$con=mysqli_connect("127.0.0.1","jahaann","Jahaann#321","haleeb");


//   Calling the InsertrOLE FUNCTION
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form is submitted, process the data
    $role_name = $_POST["name"];
    Role::insertRole($role_name, $con);
}
header('Location:../home.php');

//   Defining Role Class
class Role
{
    protected $permissions;

    protected function __construct() {
        $this->permissions = array();
    }

    public static function insertRole($role_name, $con) {
        $sql = "INSERT INTO roles (role_name) VALUES (?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $role_name);
        return $stmt->execute();
       
    }
   

}
    
?>