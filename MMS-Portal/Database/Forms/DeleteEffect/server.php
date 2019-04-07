<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 16/04/2018
 * Time: 17:56
 * Logica komt van hier: https://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
 */
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';

if (isset($_POST['delete_effect']) && isset($_POST['delete_idEffect'])) {
    EffectDB::deleteById($_POST['delete_idEffect']);
    
}

if (isset($_POST['delete_cause']) && isset($_POST['delete_idCause'])) {
    CauseDB::deleteCauseById($_POST['delete_idCause']);
}

?>

