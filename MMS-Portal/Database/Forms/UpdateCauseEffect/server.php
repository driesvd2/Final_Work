<?php 
session_start();
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';


//Update name

if (isset($_POST['update_causeEffect']) && isset($_POST['id']) && isset($_POST['cause']) && isset($_POST['effect'])) {
   
    $arrayMeta = array();
    
    $arrayMeta['cause'] = $_POST['cause'];
    $arrayMeta['effect'] = $_POST['effect'];

    $causeEffectMetaData = CauseEffectDB::getAllMetaColumnsOfCauseEffect();
    foreach($causeEffectMetaData as $m){
        if(!empty($_POST[$m]) && !ctype_space($_POST[$m])){
        $arrayMeta[$m] = $_POST[$m];
        } else {
        $arrayMeta[$m] = null;
        }  
    }
    
    
    CauseEffectDB::updateCauseEffectEntity($arrayMeta, $_POST['id']);
    EffectDB::setStatus2($arrayMeta['effect']);
     
    
    
    if($_SESSION['causeEffectObjEdit']['effect'] != $arrayMeta['effect']){
        
        $searchOfEffectID = CauseEffectDB::getCausebyEffectIdOne($_SESSION['causeEffectObjEdit']['effect']);
        $searchOfClusterEffectsForCauseEffect = ClusterDB::getSearchClusterEffects($_SESSION['causeEffectObjEdit']['effect']);

        if(empty($searchOfEffectID) && empty($searchOfClusterEffectsForCauseEffect)) {
            EffectDB::setStatus1AfterDelete($_SESSION['causeEffectObjEdit']['effect']);   
        }
    }
      
    unset($_SESSION['causeEffectObjEdit']);
    unset($_SESSION['causeObjEdit']);
    unset($_SESSION['effectObjEdit']);
    
    header('location: relations.php'); 
 

}
 

?>