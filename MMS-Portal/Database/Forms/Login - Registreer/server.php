<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 16/04/2018
 * Time: 17:56
 * Logica komt van hier: https://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
 */

include_once './Database/DAO/UserDB.php';

$db = mysqli_connect('dt5.ehb.be', '1819FW_DRIESD_STEFANOSS', 'DzwWqw', '1819FW_DRIESD_STEFANOSS');

//LOGIN GEBRUIKER
if (isset($_POST['login_gebruiker']) && isset($_POST['log_username']) && isset($_POST['log_paswoord'])) {

    $logUsername = mysqli_real_escape_string($db, $_POST['log_username']);
    $logPassword = mysqli_real_escape_string($db, $_POST['log_paswoord']);
    $logPassword = strtoupper(hash('sha512', $logPassword));
    $type = UserDB::Login($logUsername, $logPassword);
    $_SESSION["logged"] = true;

    if ($type == 0) {
        $_SESSION['login'] = $_POST['log_username'];
        $_SESSION['type'] = 0;
        header('location: index.php');
    } elseif ($type == 1) {
        $_SESSION['login'] = $_POST['log_username'];
        $_SESSION['type'] = 1;
        header('location: index.php');
    } else {
        unset($_SESSION['login']);
        unset($_SESSION['type']);
    }
}
