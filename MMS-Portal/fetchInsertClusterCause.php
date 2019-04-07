<?php 

include './Database/Forms/DeleteCause/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ErrorDB.php';

$connect = mysqli_connect('dt5.ehb.be', '1819FW_DRIESD_STEFANOSS', 'DzwWqw', '1819FW_DRIESD_STEFANOSS');
$output = '';
if(isset($_POST["queryClusterCause"]))
{
    $search = mysqli_real_escape_string($connect, $_POST["queryClusterCause"]);
    $query = "SELECT * FROM Cause WHERE CauseName LIKE '%".$search."%'";
}else{
    $query = "SELECT * FROM Cause ORDER BY idCause";
}

$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0){
    

$output .= '<div class="form-check">';
    
    while($row = mysqli_fetch_array($result)){
        $output .= '<input class="form-check-input" onchange="this.form.submit()" type="radio" name="selectedCause" type="radio" value="'.$row["idCause"].'" id="'.$row["idCause"].'"></td>
                 <label class="form-check-label" for="'.$row["idCause"].'">
                            '.$row["CauseName"].'
                        </label><br/>';
    }
    
    $output.= '</div>';
    
    echo $output;
}else {
    echo 'Data Not Found';
}







?>