<?php 

include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/Mastermind.php';


if (isset($_POST['sendForWebservice']) && isset($_POST['selectedEffectsSessionWeb'])) {
    
    $_SESSION["catchedCause"] = array();
    
    asort($_SESSION["effectOnChangeNameWeb"]);
    
    //array_push($_SESSION["catchedCause"], Mastermind::searchMastermind($_SESSION["effectOnChangeNameWeb"]));
    
    $_SESSION["catchedCause"] = Mastermind::searchMastermind($_SESSION["effectOnChangeNameWeb"]);

    unset($_SESSION["effectOnChangeNameWeb"]);
    
}


if(isset($_POST['new_search_webservice'])){
    
    
    unset($_SESSION["catchedCause"]);
    
}


if(isset($_POST['unsetSessionsWebservice'])){
    
    
    unset($_SESSION['effectOnChangeNameWeb']);  
    
}



?>