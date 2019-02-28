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
}


?>