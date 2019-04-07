<?php 

include_once './Database/DAO/UserDB.php';

//Update CauseName

if (isset($_POST['update_user']) && isset($_POST['update_username']) && isset($_POST['userId']) && isset($_POST['update_password']) && isset($_POST['adminOrNot'])) {
    
    $username = $_POST['update_username'];
    $userid = $_POST['userId'];
    $password = $_POST['update_password'];
    $adminornot = $_POST['adminOrNot'];
    
    print($userid);
    print($username);
    print($password);
    print($adminornot);
    UserDB::updateUser($username,$password,$adminornot,$userid);
    header('location: manageUser.php');    
    
}else{
    print("camarchepas");
}


?>