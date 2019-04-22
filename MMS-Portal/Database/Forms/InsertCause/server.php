<?php 

include_once './Database/DAO/CauseDB.php';

//Insert Cause in cause table
if (isset($_POST['insert_cause']) && isset($_POST['Cause'])) {
    $cause = $_POST['Cause'];
    if (isset($cause) && !empty($cause) && !is_null($cause))
    {
        CauseDB::insert($cause);
    }else{
        header('location: insert_Cause.php');
    }
    
 if (isset($_SESSION["insertCauseFromInsertCluster"]) && $_SESSION["insertCauseFromInsertCluster"] == insertCluster) {
        header('location: insert_Cluster.php');
        unset($_SESSION["insertCauseFromInsertCluster"]);
 }
    
    
 if (isset($_SESSION["insertCauseFromInsertCauseEffect"]) && $_SESSION["insertCauseFromInsertCauseEffect"] == insertCauseEffect) {
        header('location: insert_Cause_Effect.php');
        unset($_SESSION["insertCauseFromInsertCauseEffect"]);
 }
    
 if (isset($_SESSION["insertCauseFromEditCauseEffect"]) && $_SESSION["insertCauseFromEditCauseEffect"] == editCauseEffect) {
        header('location: edit_cause_effect.php');
        unset($_SESSION["insertCauseFromEditCauseEffect"]);
 }    
    

 if (isset($_SESSION["insertCauseFromEditCluster"]) && $_SESSION["insertCauseFromEditCluster"] == editCluster) {
        header('location: edit_cluster.php');
        unset($_SESSION["insertCauseFromEditCluster"]);
 }    

  
    
    

    
}


?>