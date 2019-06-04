<?php 

include_once './Database/DAO/ClusterDB.php';

    

if(isset($_POST['submitAlterNewColumnCluster']) && isset($_POST['AlterNewColumnCluster'])){
    ClusterDB::addColumnCluster($_POST['AlterNewColumnCluster']);
}

if(isset($_POST['deleteColumnCluster'])){
    ClusterDB::deleteColumnCluster($_POST['deleteColumnCluster']);
}

if(isset($_POST['editColumn']) && isset($_POST['oldColumn']) && isset($_POST['newColumn'])){
    ClusterDB::editColumnCluster($_POST['oldColumn'],$_POST['newColumn']);
}

?>