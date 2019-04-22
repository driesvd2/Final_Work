<?php

include_once './Database/DAO/EffectDB.php';


if (isset($_POST['insert_effect_admin'])) {
    
    $name = $_POST['name'];
    if (isset($name) && !empty($name))
    {
        EffectDB::insertNewEffect($name,1);
    }
}


?>