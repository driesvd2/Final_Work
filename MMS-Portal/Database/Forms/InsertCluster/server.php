<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 24/02/2019
 * Time: 12:36
 */

include_once './Database/DAO/ClusterDB.php';
include_once './Database/DAO/EffectDB.php';

//Insert Cause in cause table
if (isset($_POST['insert_ClusterSession']) && isset($_SESSION['effectOnChangeName']) && isset($_POST['selectedCauseSession'])) {
    if (!ClusterDB::ifExists($_POST['selectedCauseSession'], $_SESSION['effectOnChangeName'])) {
        foreach ($_SESSION['effectOnChangeName'] as $e){
            EffectDB::setStatus2($e);
        }
        
        ClusterDB::insert($_POST['selectedCauseSession'], $_SESSION['effectOnChangeName']);
        header('location: relations.php');
        unset($_SESSION['causeOnChangeName']);
        unset($_SESSION['effectOnChangeName']);    
    }
}

if(isset($_POST['unsetSessionsCluster'])){
    
    unset($_SESSION['causeOnChangeName']);
    unset($_SESSION['effectOnChangeName']);  
    
}




?>

