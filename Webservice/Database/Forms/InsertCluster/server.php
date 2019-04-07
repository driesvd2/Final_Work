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
if (isset($_POST['insert_Cluster']) && isset($_POST['effects']) && isset($_POST['Cause'])) {
    if (!ClusterDB::ifExists($_POST['Cause'], $_POST['effects'])) {
        foreach ($_POST['effects'] as $e){
            EffectDB::setStatus2($e);
        }
        ClusterDB::insert($_POST['Cause'], $_POST['effects']);
    }
}

if (isset($_POST['Delete_Cluster_id']) && isset($_POST['Delete_Cluster'])) {
    ClusterDB::deleteById($_POST['Delete_Cluster_id']);
}


?>