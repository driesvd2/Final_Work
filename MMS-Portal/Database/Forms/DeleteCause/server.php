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
include_once './Database/DAO/ClusterDB.php';
include_once './Database/DAO/CauseEffectDB.php';


function errorHandlingDeleteEffect(){
if (isset($_POST['delete_effect']) && isset($_POST['delete_idEffect'])) {
    
        if(ClusterDB::getSearchClusterEffects($_POST['delete_idEffect']) && CauseEffectDB::getCausebyEffectIdOne($_POST['delete_idEffect'])){
            
            echo '<span style="color:red">Delete denied: Effect exists in Cluster and in Cause-Effect</span>';
            
        }else if(CauseEffectDB::getCausebyEffectIdOne($_POST['delete_idEffect'])){
            
            echo '<span style="color:red">Delete denied: Effect exists in Cause-Effect</span>';
            
        } else if(ClusterDB::getSearchClusterEffects($_POST['delete_idEffect'])) {
            
            echo '<span style="color:red">Delete denied: Effect exists in Cluster</span>';
    
        } else {
            EffectDB::deleteById($_POST['delete_idEffect']);
        }
        
        
    }
}
 
function errorHandlingDeleteCause(){
    
    if (isset($_POST['delete_cause']) && isset($_POST['delete_idCause'])) {
    
       if(ClusterDB::getCauseClusterWhereIdCause($_POST['delete_idCause']) && CauseEffectDB::getCauseEffectbyCauseForDelete($_POST['delete_idCause'])){
            
            echo '<span style="color:red">Delete denied: Cause exists in Cluster and in Cause-Effect</span>';
            
        } else if(ClusterDB::getCauseClusterWhereIdCause($_POST['delete_idCause'])){
           
           echo '<span style="color:red">Delete denied: Cause exists in Cluster</span>';
       
       } else if (CauseEffectDB::getCauseEffectbyCauseForDelete($_POST['delete_idCause'])){
           
           echo '<span style="color:red">Delete denied: Cause exists in Cause - Effect</span>';
       } else {
           CauseDB::deleteCauseById($_POST['delete_idCause']);
       } 
        
    }

}



?>