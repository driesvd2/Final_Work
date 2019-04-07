<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 16/04/2018
 * Time: 17:56
 * Logica komt van hier: https://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
 */
include_once './Database/DAO/UserDB.php';

//Delete user
if (isset($_POST['delete_user']) && isset($_POST['delete_userid'])) {
    UserDB::deleteByIdQueue($_POST['delete_userid']);
}

?>