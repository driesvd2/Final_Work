<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 24/02/2019
 * Time: 12:36
 */

session_start();

include_once './Database/DAO/ClusterDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/CauseEffectDB.php';


if (isset($_POST['edit_The_Cluster']) && isset($_SESSION['effectsClusterOfObjEdit']) && isset($_POST['selCause'])) {
        
    $arrayMeta = array();
    $arrayMeta['cause'] = $_POST['selCause'];
    $arrayMeta['effects'] = $_SESSION['effectsClusterOfObjEdit'];
    
    if (!ClusterDB::ifExists($_POST['selCause'], $arrayMeta['effects'])) {
       
        
        
        $clusterMetaData = ClusterDB::getAllMetaColumnsOfCluster();
    
        foreach($clusterMetaData as $m){
            if(!empty($_POST[$m]) && !ctype_space($_POST[$m])){
            $arrayMeta[$m] = $_POST[$m];
            } else {
            $arrayMeta[$m] = null;
            }  
        }
        
        
        ClusterDB::updateCluster($arrayMeta,$_POST['id']);
        foreach($arrayMeta['effects'] as $a){
            EffectDB::setStatus2($a);
        }
        
        
        $_SESSION['effectsConversion'] = array();

        foreach (ClusterDB::translateStringToEffects($_SESSION['clusterObjEdit']['effects']) as $theTranslation) {

        array_push($_SESSION['effectsConversion'], $theTranslation);
            
        }
  
        
        if($_SESSION['effectsConversion'] != $arrayMeta['effects']){
            
            foreach($_SESSION['effectsConversion'] as $a){
                $CauseEffect = CauseEffectDB::getCausebyEffectIdOne($a);
                $Cluster = ClusterDB::getSearchClusterEffects($a);
                if(empty($CauseEffect) && empty($Cluster)){
                    EffectDB::setStatus1AfterDelete($a);
                }
            }
            
        }
            
        header('location: relations.php');

        unset($_SESSION['effectsClusterOfObjEdit']);    
        unset($_SESSION['clusterObjEdit']);    
        unset($_SESSION['effectsConversion']);    
        
        
    }
}
 
 
 

?>