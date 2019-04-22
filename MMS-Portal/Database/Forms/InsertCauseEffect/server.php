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
function handleErrorRadioButtons(){
    
if(isset($_POST['insert_CauseEffect'])){
    
    if(!isset($_POST['Effect']) || !isset($_POST['Cause'])){
        
        echo '<span style="color:red">You have to select a cause and an effect</span>';
           
    }else{
        
            if (!CauseEffectDB::ifExists($_POST['Cause'],$_POST['Effect'])){
                EffectDB::setStatus2($_POST['Effect']);
                CauseEffectDB::insert($_POST['Cause'],$_POST['Effect']);
                if(isset($_SESSION["deIdVanStatusPageCauseEffect"])){
                    unset($_SESSION["deIdVanStatusPageCauseEffect"]);
                }
                
            }
        }
    
    }   
    
}

if (isset($_POST['Delete_causeEffect_id']) && isset($_POST['Delete_causeEffect'])) {
    
    CauseEffectDB::deleteById($_POST['Delete_causeEffect_id']);
         
} 
  
if(isset($_POST["unsetSessionsCauseEffect"])){
    
    unset($_SESSION["deIdVanStatusPageCauseEffect"]);
    
}




?>