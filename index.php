<?php 
// include('Action/db_connection.php');
session_start();
error_reporting(E_ERROR | E_PARSE);
if(isset($_SESSION['auth']))   // Checking whether the session is already there or not if 

{
   
    header("Location:home.php"); 
}
?>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page </title>
        <link rel="icon" type="gif" href="https://haleebfoods.com/wp-content/uploads/2022/08/favicon.png" />
        <link rel="stylesheet" href="css/index.css">
    </head>

    <body>
        <section>
            <div class="login-box">
                <form class="form" action="Action/login.php" method="POST">
                    <h2 style="color:black;">Login</h2>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="mail"></ion-icon>
                        </span>
                        <input type="text" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                   
                    <button type="submit">Login</button>
                    
                </form>
            </div>
        </section>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>

</html>