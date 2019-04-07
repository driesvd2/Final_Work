<?php

include_once './Database/DAO/EffectDB.php';




if (isset($_POST['update_effect_zero']) && isset($_POST['update_idEffect_zero'])) {
    
    $ideffect = $_POST['update_idEffect_zero'];
    
    $name = $_POST['unap_effectName'];
    
    var_dump($ideffect);
    
    var_dump($name);
    
    print_r($_POST['update_idEffect_zero']);
    print_r($_POST['unap_effectName']);
    print_r("rerererere");
    
    EffectDB::setStatus1($_POST['update_idEffect_zero'], $_POST['unap_effectName'] );
    
    
}






 






?>

