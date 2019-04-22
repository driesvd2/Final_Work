<?php 

include_once './Database/DAO/EffectDB.php';

//Update name

if (isset($_POST['update_effect']) && isset($_POST['id']) && isset($_POST['name']) && isset($_POST['status'])) { 
    
$arrayMeta = array();

$arrayMeta['name'] = $_POST['name'];
$arrayMeta['status'] = $_POST['status'];

$effectMetaData = EffectDB::getAllColumnsOfEffect();
foreach ($effectMetaData as $m) {
    if(!empty($_POST[$m]) && !ctype_space($_POST[$m])){
        $arrayMeta[$m] = $_POST[$m];
    } else {
        $arrayMeta[$m] = null;
    }  
}

EffectDB::update($arrayMeta, $_POST['id']);

    
    
header('location: index.php'); 
 
}
 

?>