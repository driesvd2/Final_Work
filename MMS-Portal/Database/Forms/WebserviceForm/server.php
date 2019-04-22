<?php 

include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/Mastermind.php';
include_once './Database/DAO/CauseEffectDB.php';
session_start();

if (isset($_POST['sendForWebservice']) && isset($_POST['selectedEffectsSessionWeb'])) {
    
    $_SESSION["catchedCause"] = array();

    $_SESSION["catchedCauseEffects"] = array();
    
    asort($_SESSION["effectOnChangeNameWeb"]);
    
    $_SESSION["catchedCause"] = Mastermind::searchMastermind($_SESSION["effectOnChangeNameWeb"]);

    $_SESSION["catchedCauseEffects"] = CauseEffectDB::getCauseEffects($_SESSION["effectOnChangeNameWeb"]);

    unset($_SESSION["effectOnChangeNameWeb"]);
    
}


if(isset($_POST['new_search_webservice'])){
    
    unset($_SESSION["catchedCause"]);
    
}


if(isset($_POST['unsetSessionsWebservice'])){
    
    
    unset($_SESSION['effectOnChangeNameWeb']);  
    
}



?>