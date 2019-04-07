<?php

include_once './Database/DAO/EffectDB.php';




if (isset($_POST['update_effect_zero']) && isset($_POST['update_idEffect_zero'])) {
    EffectDB::setStatus1($_POST['update_idEffect_zero']);
}













?>

