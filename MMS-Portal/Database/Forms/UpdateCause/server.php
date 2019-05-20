<?php 

include_once './Database/DAO/CauseDB.php';

//Update name

if (isset($_POST['update_cause']) && isset($_POST['id']) && isset($_POST['name'])) {

$arrayMeta = array();

$arrayMeta['name'] = $_POST['name'];
$arrayMeta['tag'] = $_POST['tag'];

$causeMetaData = CauseDB::getAllMetaColumnsOfCause();
foreach ($causeMetaData as $m) {
    if(!empty($_POST[$m]) && !ctype_space($_POST[$m])){
        $arrayMeta[$m] = $_POST[$m];
    } else {
        $arrayMeta[$m] = null;
    }  
}
 
CauseDB::update($arrayMeta, $_POST['id']);

header('location: index.php');    
 
}
 
 
?>