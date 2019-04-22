<?php 

include_once './Database/DAO/CauseDB.php';

//Update name

if (isset($_POST['update_cause']) && isset($_POST['update_causename']) && isset($_POST['causeid'])) {
    $causeName = $_POST['update_causename'];
    $causeId = $_POST['causeid'];
    
    
    CauseDB::update($causeName, $causeId);
    header('location: index.php');    
    
}else{
    print("camarchepas");
}


?>