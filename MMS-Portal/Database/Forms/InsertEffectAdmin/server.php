<?php

include_once './Database/DAO/EffectDB.php';


if (isset($_POST['insert_effect_admin'])) {
    
    $EffectName = $_POST['EffectName'];
    if (isset($EffectName) && !empty($EffectName))
    {
        //$newUser = new User(null,$username,$password,1);
        EffectDB::insertNewEffect($EffectName,1);
    }
}

?>