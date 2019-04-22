<?php 

include_once './Database/DAO/UserDB.php';

//Update name

if (isset($_POST['update_user']) && isset($_POST['update_username']) && isset($_POST['id']) && isset($_POST['update_password']) && isset($_POST['adminOrNot'])) {
    
    $username = $_POST['update_username'];
    $userid = $_POST['id'];
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