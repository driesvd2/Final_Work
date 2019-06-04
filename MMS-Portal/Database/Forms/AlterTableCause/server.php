<?php 

include_once './Database/DAO/CauseDB.php';

if(isset($_POST['submitAlterCauseName']) && isset($_POST['AlterCauseName'])){
    CauseDB::addColumnCause($_POST['AlterCauseName']);
}

if(isset($_POST['deleteColumnCause'])){
    CauseDB::deleteColumnCause($_POST['deleteColumnCause']);
}

if(isset($_POST['editColumn']) && isset($_POST['oldColumn']) && isset($_POST['newColumn'])){
    var_dump($_POST['oldColumn']);
    var_dump($_POST['newColumn']);
    CauseDB::editColumnCause($_POST['oldColumn'],$_POST['newColumn']);
}
 


?>