<?php 

include_once './Database/DAO/UserDB.php';
  

if(isset($_POST['submitPost']) && isset($_POST['postTest'])){
    CauseDB::addColumnCause($_POST['postTest']);
}

?>