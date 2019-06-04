<?php 

include './Database/Forms/DeleteCause/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/CauseTagDB.php';

$connect = mysqli_connect('dt5.ehb.be', '1819FW_DRIESD_STEFANOSS', 'DzwWqw', '1819FW_DRIESD_STEFANOSS');
$output = '';
if(isset($_POST["queryClusterEditCause"]) && isset($_POST["columnSearchCauseClusterEdit"]) && $_POST["columnSearchCauseClusterEdit"] == 'tag')
{
    $search = mysqli_real_escape_string($connect, $_POST["queryClusterEditCause"]);
    $querySearchTag = CauseTagDB::getSearchTagID($search);
    
    $temp = "SELECT * FROM Cause WHERE ";

    foreach($querySearchTag as $q){
        $temp .= "tag='$q->id' OR ";
    }
    $temp .= " 1!=1 ORDER BY id ASC";   
    $query = $temp;

} else if(isset($_POST["queryClusterEditCause"]) && isset($_POST["columnSearchCauseClusterEdit"]))
{
    $search = mysqli_real_escape_string($connect, $_POST["queryClusterEditCause"]);
    $query = "SELECT * FROM Cause WHERE ".$_POST["columnSearchCauseClusterEdit"]." LIKE '%".$search."%'";
}else{
    $query = "SELECT * FROM Cause ORDER BY id";
}

$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0){
    
$output .= '<div class="form-check">';
    
    while($row = mysqli_fetch_array($result)){
        $output .= '<input class="form-check-input" onchange="this.form.submit()" type="radio" name="cause" type="radio" value="'.$row["id"].'" id="'.$row["id"].'"></td>
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