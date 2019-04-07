<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 24/02/2019
 * Time: 13:33
 */

include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/EffectDB.php';

//Insert Cause in cause table
if (isset($_POST['insert_CauseEffect']) && isset($_POST['Effect']) && isset($_POST['Cause'])) {
    if (!CauseEffectDB::ifExists($_POST['Cause'],$_POST['Effect'])){
        EffectDB::setStatus2($_POST['Effect']);
        CauseEffectDB::insert($_POST['Cause'],$_POST['Effect']);
        if(isset($_SESSION["deIdVanStatusPageCauseEffect"])){
            unset($_SESSION["deIdVanStatusPageCauseEffect"]);
        }
    }
}

if (isset($_POST['Delete_causeEffect_id']) && isset($_POST['Delete_causeEffect'])) {
    
    CauseEffectDB::deleteById($_POST['Delete_causeEffect_id']);
    
    $deletedEffectFromCauseEffect = CauseEffectDB::getCauseEffectWhereIdEffect($_POST['Delete_causeEffect_id']);
   
    if($deletedEffectFromCauseEffect == null){
        EffectDB::setStatus1AfterDelete($deletedEffectFromCauseEffect->Effect_idEffect);
    }
    
    
} 
 
if(isset($_POST["unsetSessionsCauseEffect"])){
    
    unset($_SESSION["deIdVanStatusPageCauseEffect"]);
    
}




?>