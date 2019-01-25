<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 16/04/2018
 * Time: 17:56
 * Logica komt van hier: https://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
 */
include_once './Database/DAO/EffectDB.php';

//Insert Effect in EffectQueue
if (isset($_POST['insert_effect']) && isset($_POST['Effect'])) {
    $effect = $_POST['Effect'];
    if (isset($effect) && !empty($effect) && !is_null($effect))
    {
        EffectDB::insertQueue($effect);
    }else{
        header('location: insert.php');
    }
}

?>