<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 24/02/2019
 * Time: 19:23
 */

include_once './Database/DAO/ClusterDB.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/CauseDB.php';


if (isset($_POST['Delete_Cluster_id']) && isset($_POST['Delete_Cluster'])) {
     
    $catchedClusterObj = ClusterDB::getById($_POST['Delete_Cluster_id']);
    ClusterDB::deleteById($_POST['Delete_Cluster_id']);
    $arrayEffects = ClusterDB::translateStringToEffects($catchedClusterObj[0]->effects);
    foreach($arrayEffects as $a){
        $CauseEffect = CauseEffectDB::getCausebyEffectIdOne($a);
        $Cluster = ClusterDB::getSearchClusterEffects($a);
        if(empty($CauseEffect) && empty($Cluster)){
            EffectDB::setStatus1AfterDelete($a);
        }
    }  
}
  
if (isset($_POST['Delete_causeEffect_id']) && isset($_POST['Delete_causeEffect'])) {

    $catchedCauseEffectObj = CauseEffectDB::getCausebyEffectId($_POST['Delete_causeEffect_id']);
    CauseEffectDB::deleteById($_POST['Delete_causeEffect_id']);
    $searchOfEffectID = CauseEffectDB::getCausebyEffectIdOne($catchedCauseEffectObj[0]->effect);
    $searchOfClusterEffectsForCauseEffect = ClusterDB::getSearchClusterEffects($catchedCauseEffectObj[0]->effect);

    if(empty($searchOfEffectID) && empty($searchOfClusterEffectsForCauseEffect)){
        EffectDB::setStatus1AfterDelete($catchedCauseEffectObj[0]->effect);   
    }
}
?>