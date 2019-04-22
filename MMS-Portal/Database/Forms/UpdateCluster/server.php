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
        

        
        header('location: relations.php');

        unset($_SESSION['effectsClusterOfObjEdit']);    
        unset($_SESSION['clusterObjEdit']);    
        
        
    }
}

 
 

?>