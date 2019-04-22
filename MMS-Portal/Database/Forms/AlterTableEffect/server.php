<?php 

include_once './Database/DAO/EffectDB.php';


if(isset($_POST['submitAlterNewColumnEffect']) && isset($_POST['AlterNewColumnEffect'])){
    EffectDB::addColumnEffect($_POST['AlterNewColumnEffect']);
}

if(isset($_POST['deleteColumnEffect'])){
    EffectDB::deleteColumnEffect($_POST['deleteColumnEffect']);
}

?>