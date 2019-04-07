<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 16/04/2018
 * Time: 17:56
 * Logica komt van hier: https://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
 */
include_once './Database/DAO/EffectDB.php';

//Approve Effect
if (isset($_POST['approve_effect']) && isset($_POST['aprove_EffectName']) && isset($_POST['aprove_EffectId'])) {
    EffectDB::insert($_POST['aprove_EffectName']);
    EffectDB::deleteByIdQueue($_POST['aprove_EffectId']);
}

//Decline Effect
if (isset($_POST['decline_effect']) && isset($_POST['decline_EffectId'])) {
    EffectDB::deleteByIdQueue($_POST['decline_EffectId']);
}
?>