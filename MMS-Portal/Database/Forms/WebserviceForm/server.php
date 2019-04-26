<?php 

include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/Mastermind.php';
include_once './Database/DAO/CauseEffectDB.php';
session_start();

if (isset($_POST['sendForWebservice']) && isset($_POST['selectedEffectsSessionWeb']) || isset($_POST['more'])) {
    asort($_SESSION["effectOnChangeNameWeb"]);
    
    $_SESSION["catchedCause"] = Mastermind::searchMastermind($_SESSION["effectOnChangeNameWeb"]);
    if (sizeof($_SESSION["effectOnChangeNameWeb"]) > 20) {
        $array = array();
        $array1 = array();
        if (isset($_POST['more'])) {
            $_SESSION['more'] += 5;
            for ($i=$_SESSION['more']; $i < $_SESSION['more'] + 5; $i++) {
                if (isset($_SESSION["effectOnChangeNameWeb"][$i])) {
                    array_push($array1, $_SESSION["effectOnChangeNameWeb"][$i]);
                } 
            }
            $causeEffect = CauseEffectDB::getCauseEffects($array1);
            foreach($causeEffect as $c){
                array_push($_SESSION["catchedCauseEffects"], $c);
            }
        }else{
            for ($i=0; $i <5; $i++) { 
                array_push($array, $_SESSION["effectOnChangeNameWeb"][$i]);
            }
            $_SESSION["catchedCauseEffects"] = CauseEffectDB::getCauseEffects($array);
            $_SESSION['more'] = 0;
        }
    } else{
        $_SESSION["catchedCauseEffects"] = CauseEffectDB::getCauseEffects($_SESSION["effectOnChangeNameWeb"]);
        unset($_SESSION["more"]);
        unset($_SESSION["effectOnChangeNameWeb"]);
    }
    
}


if(isset($_POST['new_search_webservice'])){
    unset($_SESSION["more"]);
    unset($_SESSION["effectOnChangeNameWeb"]);
    unset($_SESSION["catchedCause"]);
}


if(isset($_POST['unsetSessionsWebservice'])){
    unset($_SESSION["more"]);
    unset($_SESSION['effectOnChangeNameWeb']);  
    unset($_SESSION["catchedCause"]);
}



?>