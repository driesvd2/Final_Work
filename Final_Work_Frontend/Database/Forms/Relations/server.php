<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 24/02/2019
 * Time: 19:23
 */


include_once './Database/DAO/ClusterDB.php';
include_once './Database/DAO/CauseEffectDB.php';

//Insert Cause in cause table
if (isset($_POST['Delete_Cluster_id']) && isset($_POST['Delete_Cluster'])) {
    ClusterDB::deleteById($_POST['Delete_Cluster_id']);
}

if (isset($_POST['Delete_causeEffect_id']) && isset($_POST['Delete_causeEffect'])) {
    CauseEffectDB::deleteById($_POST['Delete_causeEffect_id']);
}


?>