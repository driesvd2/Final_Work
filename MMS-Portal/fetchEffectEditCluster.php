<?php

include './Database/Forms/InsertCauseEffect/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';

$connect = mysqli_connect('dt5.ehb.be', '1819FW_DRIESD_STEFANOSS', 'DzwWqw', '1819FW_DRIESD_STEFANOSS');

$outputEffect = '';
if(isset($_POST["queryClusterEditEffect"]) && isset($_POST["columnSearchEffectClusterEdit"]))
{
    $searchEffect = mysqli_real_escape_string($connect, $_POST["queryClusterEditEffect"]);
    $queryEffect = "SELECT * FROM Effect WHERE ".$_POST["columnSearchEffectClusterEdit"]." LIKE '%".$searchEffect."%' AND (status = 1 OR status = 2)";
} else {
    $queryEffect = "SELECT * FROM Effect WHERE (status = 1 OR status = 2) ORDER BY id";
}

$resultEffect = mysqli_query($connect, $queryEffect);

if(mysqli_num_rows($resultEffect) > 0){
    

    $outputEffect .= '<div class="form-check">';
    
    while($rowEffect = mysqli_fetch_array($resultEffect)){
        $outputEffect .= '<input class="form-check-input" onchange="this.form.submit()" type="checkbox" name="effect" value="'.$rowEffect["id"].'" id="'.$rowEffect["id"].'"></td>
                 <label class="form-check-label" for="'.$rowEffect["id"].'">
                           '.$rowEffect["id"].'. '.$rowEffect["name"].'
                        </label><br/>';
    }
     
    $outputEffect.= '</div>';
    
    echo $outputEffect;
    
} else {
    echo 'Data Not Found';
}

  

?>