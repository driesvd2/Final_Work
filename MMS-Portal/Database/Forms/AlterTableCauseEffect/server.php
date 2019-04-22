<?php 


include_once './Database/DAO/CauseEffectDB.php';

if(isset($_POST['submitAlterCauseEffectNewColumn']) && isset($_POST['AlterCauseEffectNewColumn'])){
    CauseEffectDB::addColumnCauseEffect($_POST['AlterCauseEffectNewColumn']);
}


if(isset($_POST['deleteColumnCauseEffect'])){
    CauseEffectDB::deleteColumnCauseEffect($_POST['deleteColumnCauseEffect']);
}



?> 