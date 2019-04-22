<?php

include_once './Database/DAO/EffectDB.php';




if (isset($_POST['update_effect_zero']) && isset($_POST['update_idEffect_zero'])) {
    
    $ideffect = $_POST['update_idEffect_zero'];
    
    $name = $_POST['unap_effectName'];
    
    EffectDB::setStatus1($_POST['update_idEffect_zero'], $_POST['unap_effectName'] );
    
    
}

if (isset($_POST['update_effect_one']) && isset($_POST['update_idEffect_zero'])){
    EffectDB::deleteById($_POST['update_idEffect_zero']);
}






 






?>

