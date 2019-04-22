<?php 

include './Database/Forms/DeleteCause/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';

$connect = mysqli_connect('dt5.ehb.be', '1819FW_DRIESD_STEFANOSS', 'DzwWqw', '1819FW_DRIESD_STEFANOSS');
$output = '';

if(isset($_POST["query"]) && isset($_POST["columnSearch"]))
{
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query = "SELECT * FROM Cause WHERE ".$_POST["columnSearch"]." LIKE '%".$search."%'";
}else{
    $query = "SELECT * FROM Cause ORDER BY id";
}

$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0){
    

$output .= '<div class="form-check">';
    
    while($row = mysqli_fetch_array($result)){
        $output .= '<input class="form-check-input" type="radio" name="Cause" value="'.$row["id"].'" id="'.$row["id"].'"></td>
                 <label class="form-check-label" for="'.$row["id"].'">
                           '.$row["id"].'. '.$row["name"].'
                        </label><br/>';
    }
    
    $output.= '</div>';
    
    echo $output;
}else {
    echo 'Data Not Found';
}

?>