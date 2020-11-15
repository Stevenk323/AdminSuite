<?php 
session_start();
include ('database.php');
$username = $_POST["Username"];
$password = $_POST["Password"];


$query = "SELECT * FROM Users WHERE Username = ? LIMIT 1";
$check = $con->prepare($query);
$check->bind_param("s", $username);
$check->execute();
$check->store_result();
$check->bind_result($user, $pass, $role);
$check->fetch();

$row = $check->num_rows;

if($row == 0){ //user does not exist
    echo "User does not exist";
}
else if($row == 1){
    echo "User exists";

    if($password == $pass && strpos($role, "ADMIN") !== false){   //user is an admin, redirect to index page  
        echo "<br>";
        echo "Oh Fun";
        $_SESSION['role'] = $role;
        $_SESSION['user'] = $username;
        header("location: index.html");
    }
    else if($pass != $password) //user password is wrong 
    {
        echo "wrong password or username";

    }
    else{ //user is not an admin, redirect to error page
        echo "user is not an Admin";
    }
}

?>