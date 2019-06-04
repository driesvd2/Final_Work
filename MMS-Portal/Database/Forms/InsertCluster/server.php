<?php

include_once './Database/DAO/ClusterDB.php';
include_once './Database/DAO/EffectDB.php';

//Insert Cause in cause table
if (isset($_POST['insert_ClusterSession']) && isset($_SESSION['effectOnChangeName']) && isset($_POST['selectedCauseSession'])) {
    if (!ClusterDB::ifExistsInsert($_POST['selectedCauseSession'], $_SESSION['effectOnChangeName'])) {
        foreach ($_SESSION['effectOnChangeName'] as $e){
            EffectDB::setStatus2($e);
        }
        
        ClusterDB::insert($_POST['selectedCauseSession'], $_SESSION['effectOnChangeName']);
//        header('location: relations.php');
        unset($_SESSION['causeOnChangeName']);
        unset($_SESSION['effectOnChangeName']);    
    } else {
        echo '<span style="color:red;">This cluster already exists!</span>';
    }
}
 
if(isset($_POST['unsetSessionsCluster'])){
    
    unset($_SESSION['causeOnChangeName']);
    unset($_SESSION['effectOnChangeName']);  
    
}




?>