<?php 

include_once './Database/DAO/CauseDB.php';


//Insert Cause in cause table
function errorhandlingSelectedCategoryRadio(){

if (isset($_POST['insert_cause']) && isset($_POST['Cause'])) {
    $cause = $_POST['Cause'];
    
    if(empty($_POST['insertTag'])){
        
    echo '<span style="color:red">you have to select the last level category!</span>';
        
    } else { 
    
        if(isset($cause) && !empty($cause) && !is_null($cause)) {
            CauseDB::insert($cause,$_POST['insertTag']);
        } else {
        header('location: insert_Cause.php');
        }
        
    }
    
 if (isset($_SESSION["insertCauseFromInsertCluster"]) && $_SESSION["insertCauseFromInsertCluster"] == 'insertCluster') {
    header("location: insert_Cluster.php");
    unset($_SESSION["insertCauseFromInsertCluster"]);
 }
    
    
 if (isset($_SESSION["insertCauseFromInsertCauseEffect"]) && $_SESSION["insertCauseFromInsertCauseEffect"] == 'insertCauseEffect') {
    header("location: insert_Cause_Effect.php");
    unset($_SESSION["insertCauseFromInsertCauseEffect"]);
 }
    
 if (isset($_SESSION["insertCauseFromEditCauseEffect"]) && $_SESSION["insertCauseFromEditCauseEffect"] == 'editCauseEffect') {
    $id = $_POST['id'];
    header("location: edit_cause_effect.php?id=$id");
    unset($_SESSION["insertCauseFromEditCauseEffect"]);
        
 }    
    

 if (isset($_SESSION["insertCauseFromEditCluster"]) && $_SESSION["insertCauseFromEditCluster"] == 'editCluster') {
    $id = $_POST['id'];
    header("location: edit_cluster.php?id=$id");
    unset($_SESSION["insertCauseFromEditCluster"]);
 }
    
 
    
}

}


    
    
    
    







?>