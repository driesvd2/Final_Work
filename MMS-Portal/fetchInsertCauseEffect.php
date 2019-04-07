<?php

session_start();

include './Database/Forms/InsertCauseEffect/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ErrorDB.php';
include_once './Database/DAO/ClusterDB.php';


$connect = mysqli_connect('dt5.ehb.be', '1819FW_DRIESD_STEFANOSS', 'DzwWqw', '1819FW_DRIESD_STEFANOSS');

//function zbeub(){
//    
//    if($_SESSION["deIdVanStatusPageCauseEffect"])
//    
//}

$outputEffect = '';
if(isset($_POST["queryEffect"]))
{
    $searchEffect = mysqli_real_escape_string($connect, $_POST["queryEffect"]);
    $queryEffect = "SELECT * FROM Effect WHERE EffectName LIKE '%".$searchEffect."%'";
} else {
    $queryEffect = "SELECT * FROM Effect ORDER BY idEffect";
}

$resultEffect = mysqli_query($connect, $queryEffect);



if(mysqli_num_rows($resultEffect) > 0){
    
        
        
         $outputEffect .= '<div class="form-check">';
    
    while($rowEffect = mysqli_fetch_array($resultEffect)){
        $outputEffect .= '<input class="form-check-input" type="radio" name="Effect" value="'.$rowEffect["idEffect"].'" id="'.$rowEffect["idEffect"].'"></td>
                 <label class="form-check-label" for="'.$rowEffect["idEffect"].'">
                            '.$rowEffect["EffectName"].'
                        </label><br/>';
        
    }
    
    $outputEffect.= '</div>';
    
    echo $outputEffect;
        
    
    
  
      
   

}  else {
    echo 'Data Not Found';
}

?>