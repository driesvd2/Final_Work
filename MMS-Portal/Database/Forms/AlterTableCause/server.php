<?php 

include_once './Database/DAO/CauseDB.php';

if(isset($_POST['submitAlterCauseName']) && isset($_POST['AlterCauseName'])){
    CauseDB::addColumnCause($_POST['AlterCauseName']);
}

if(isset($_POST['deleteColumnCause'])){
    CauseDB::deleteColumnCause($_POST['deleteColumnCause']);
}

?>