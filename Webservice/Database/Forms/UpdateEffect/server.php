<?php 

include_once './Database/DAO/EffectDB.php';

//Update name

if (isset($_POST['update_effect']) && isset($_POST['effectid']) && isset($_POST['update_effectname']) && isset($_POST['update_effectstatus'])) {
    
    $effectid = $_POST['effectid'];
    $effectname = $_POST['update_effectname'];
    $effectstatus = $_POST['update_effectstatus'];
    
    
    
    EffectDB::updateEffect($effectid,$effectname,$effectstatus);
    header('location: index.php');    
    
}else{
    print("camarchepas");
}


?>