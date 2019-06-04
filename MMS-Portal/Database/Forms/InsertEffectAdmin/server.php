<?php

include_once './Database/DAO/EffectDB.php';

function errorhandlingRadioEffect(){
    
    if (isset($_POST['insert_effect_admin'])) {
        $name = $_POST['name'];
        
        if(empty($_POST['insertTag'])){
            
        echo '<span style="color:red">you have to select the last level category!</span>';
            
        } else if($name == null){
            
            echo '<span style="color:red">Fill in an Effect name!</span>';
            
        } else {
            
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
    }
    
} 


 

?>