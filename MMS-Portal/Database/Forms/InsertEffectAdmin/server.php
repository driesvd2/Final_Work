<?php

include_once './Database/DAO/EffectDB.php';


if (isset($_POST['insert_effect_admin']) && isset($_POST['insertTag'])) {
    $name = $_POST['name'];
    if (isset($name) && !empty($name))
    {
        $tag = (int) $_POST['insertTag'];
        $effect = EffectDB::getById($_POST['id']);
        if (sizeof($effect) > 0) {
            EffectDB::insertNewEffect($_POST['id'],$name,1,$tag);
        }else{
            EffectDB::insert($_POST['name'], $tag);
        }
    }
}


?>