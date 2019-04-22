<?php

include_once './Database/DAO/EffectDB.php';


if (isset($_POST['insert_effect_admin'])) {
    
    $name = $_POST['name'];
    if (isset($name) && !empty($name))
    {
        //$newUser = new User(null,$username,$password,1);
        EffectDB::insertNewEffect($name,1);
    }
}

?>