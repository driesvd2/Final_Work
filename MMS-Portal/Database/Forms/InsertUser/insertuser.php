<?php

include_once 'Database/DAO/UserDB.php';


if (isset($_POST['insert_user'])) {

    $username = $_POST['Username'];
    $password = $_POST['Password'];

    if (isset($username) && !empty($username)) {
        $password = strtoupper(hash('sha512', $password));
        UserDB::insertNewUser($username, $password, 1);
    } else {

        header('location: index.php');
    }
}
