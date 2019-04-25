<?php

include_once './Database/DAO/UserDB.php';

//Update name

if (isset($_POST['update_user']) && isset($_POST['update_username']) && isset($_POST['id']) && isset($_POST['update_password']) && isset($_POST['adminOrNot'])) {

    $username = $_POST['update_username'];
    $userid = $_POST['id'];
    $password ="";
    if (!isset($_POST['update_password']) || empty($_POST['update_password']) || ctype_space($_POST['update_password'])) {
        $user = UserDB::getById($_POST['id']);
        $password = strtoupper($user[0]->password);
    }else{
        $password = strtoupper(hash('sha512', $_POST['update_password']));
    }
    $adminornot = $_POST['adminOrNot'];

    UserDB::updateUser($username, $password, $adminornot, $userid);
    header('location: manageUser.php');
}
