<?php
//  CHECKING SESSION
session_start();
if(!isset($_SESSION['auth']))
{
  // not logged in
//   header('Location:index.php');
}



//Connectin g to DB
$con=mysqli_connect("127.0.0.1","jahaann","Jahaann#321","haleeb");

if (!$con) {
   echo "database not connected";
   }
   else{
   
   $GLOBALS["DB"] = $con;

   } 

    //  Calling to the insert function
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form is submitted, process the data
    $perm_desc = $_POST["name"];
    PrivilegedUser::insertPermissions($perm_desc, $con);
}  



class PrivilegedUser 
{
    private $roles;

    public function __construct() {
        parent::__construct();
    }

    // override User method
    public static function getByname($name) {
        $sql = "SELECT * FROM accounts WHERE name = :name";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":name" => $name));
        $result = $sth->fetchAll();

        if (!empty($result)) {
            $privUser = new PrivilegedUser();
            $privUser->id = $result[0]["id"];
            $privUser->name = $name;
            $privUser->pass = $result[0]["pass"];
            $privUser->email = $result[0]["email"];
            $privUser->initRoles();
            return $privUser;
        } else {
            return false;
        }
    }

    // populate roles with their associated permissions
    protected function initRoles() {
        $this->roles = array();
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role as t1
                JOIN roles as t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = :user_id";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":user_id" => $this->user_id));

        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
        }
    }

    // check if user has a specific privilege
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }


    // check if a user has a specific role
public function hasRole($role_name) {
    return isset($this->roles[$role_name]);
}

// insert a new role permission association
public static function insertPerm($role_id, $perm_id) {
    $sql = "INSERT INTO role_perm (role_id, perm_id) VALUES (:role_id, :perm_id)";
    $sth = $GLOBALS["DB"]->prepare($sql);
    return $sth->execute(array(":role_id" => $role_id, ":perm_id" => $perm_id));
}

// delete ALL role permissions
public static function deletePerms($con) {
    $sql = "TRUNCATE role_perm";
    $sth = $GLOBALS["DB"]->prepare($sql);
    return $sth->execute();
}

public static function insertPermissions($perm_desc, $con) {
    $sql = "INSERT INTO permissions (perm_desc) VALUES (?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $perm_desc);
    return $stmt->execute();
}

}


header('Location:../home.php');


?>