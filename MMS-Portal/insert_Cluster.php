<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 24/02/2019
 * Time: 11:48
 */

session_start();

include './Database/Forms/InsertCluster/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ErrorDB.php';
include_once './Database/DAO/ClusterDB.php';



if($_SESSION['userType'] != 0 || !isset($_SESSION['userType'])){
        header('location: login.php');
}



if(isset($_POST['searchCause']) && !empty($_POST['searchCause'])){
    
    $searchqf = $_POST['searchCause'];
    
    $searchqf = preg_replace_callback("#[^0-9a-z]#i", function($found){ return strtolower($found[1]);}, $searchqf);
    
    $querySearchCauseInsertCluster = CauseDB::getSearchCause($searchqf);
    
}

if(isset($_POST['searchEffectCluster']) && !empty($_POST['searchEffectCluster'])){
    
    $searchquery = $_POST['searchEffectCluster'];
    
    $searchquery = preg_replace_callback("#[^0-9a-z]#i", function($found){ return strtolower($found[1]);}, $searchquery);
    
    $querySearchEffectInsertCluster = EffectDB::getSearchEffectWhereStatusNotZero($searchquery);

}

if(isset($_POST["deleteEffectList"]) && isset($_POST["delete_effectFromList"])){
    
//    if(($key = array_search($_POST["deleteEffectList"], $_SESSION["effectOnChangeName"])) !== false ){
//        
//        unset($_SESSION["effectOnChangeName"][$key]);    
//        
//    }
    
//    var_dump($_POST["deleteEffectList"]);
//    var_dump($_POST["delete_effectFromList"]);
    
    
//    $key = array_search($_POST["deleteEffectList"], $_SESSION["effectOnChangeName"]);
//    if($key!==false)
//    unset($_SESSION["effectOnChangeName"]$_POST["deleteEffectList"]);
    
    

//    $key=array_search($_POST["deleteEffectList"],$_SESSION['effectOnChangeName']);
//    if($key!==false)
//    unset($_SESSION['effectOnChangeName'][$key]);
//    $_SESSION["effectOnChangeName"] = array_values($_SESSION["effectOnChangeName"]);
    
    //var_dump($key);
    
    var_dump($_POST["deleteEffectList"]);
    
   //$_SESSION['effectOnChangeName'] = array_splice($_SESSION['effectOnChangeName'], 0, 1 ,$_POST["deleteEffectList"]);
    
    unset($_SESSION['effectOnChangeName'][$_POST["deleteEffectList"]]);
    
     
    $_SESSION['effectOnChangeName'] = array_values($_SESSION['effectOnChangeName']);
   
   
    
    
    
}



?>

<html style="height: 100%;overflow:hidden">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Final Work">
    <meta name="author" content="Dries Van Dievoort & Stefanos Stoikos">
    <title>
        Final Work - MMS DB Acces
    </title>
    <link rel="stylesheet" href="./CSS/Custom.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body style="height: 100%;overflow:hidden">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Final Work - MMS DB Acces</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home
                        </a>
                    </li>
                    <li class="nav-item active">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){ ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?><span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){ ?>
                            <a class="nav-link" href="manage_status_effect.php"><?php echo 'Status Effect'; ?><span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){ ?>
                            <a class="nav-link" href="manageUser.php"><?php echo 'User Management & Webservice'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['login'])){ ?>
                        <a class="nav-link" href="index.php?logout='1'">Logout</a>
                        <?php }
                        else{ ?>
                        <a class="nav-link" href="login.php">Login</a>
                        <?php }?>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br>
    <br>
    <br>

    <div class="container" style="width: 50%; float: left; height: 80%;">
        <h1>Insert Cluster</h1>
        <?php if (isset($_GET['idEffect'])) {
            $deIdVanStatusPage = $_GET['idEffect'];
        }
        ?>
        
        <form method="post" action="insert_Cluster.php" onchange="this.form.submit()">
            <h2>Causes</h2>            
            
            <div class="wrap" style="height: 25px">
                <div class="search">
				    <div class="input-group">
					   <input type="text" class="searchTerm" name="search_textClusterCause" id="search_textClusterCause" placeholder="Filter Causes" class="form-control" />
				    </div>
			    </div>
            </div>
            <br />
            <div id="resultClusterCause" class="container" style="float: left; overflow: auto; height: 20%; margin-top: 8px; margin-bottom: 8px"></div>
                
            
            <h2>Effects</h2>
            
            <div class="wrap" style="height: 25px">
                <div class="search">
				    <div class="input-group">
					   <input type="text" class="searchTerm" name="search_textClusterEffect" id="search_textClusterEffect" placeholder="Filter Effects" class="form-control" />
				    </div>
			    </div>
            </div>
            <br/>
            <div id="resultClusterEffect" class="container" style="float: left; overflow: auto; height: 20%; margin-top: 8px; margin-bottom: 8px"></div>
            
            
        </form>
    </div>
    
    
    
    
    
    

        <form method="post" action="insert_Cluster.php">

            

                <?php  
                    
                    if (isset($_POST['selectedCause'])) {  
                    
                        
                    $caughtCause = CauseDB::getById($_POST['selectedCause']);

                    $_SESSION["causeOnChangeName"] = $caughtCause[0]->idCause;
                    
                    
                    }
                    
                        
                ?>   
            
            <?php 
            
                if(isset($deIdVanStatusPage)){
                    
                $effectsInitSessionGet = EffectDB::getById($deIdVanStatusPage);
                    
                $_SESSION["effectOnChangeName"] = array();
                    
                array_push($_SESSION["effectOnChangeName"] , $effectsInitSessionGet[0]->idEffect); 
                    
                }
            
            ?>
            

            <?php  
    
                if(isset($_POST['selectedEffects']) && !isset($_SESSION["effectOnChangeName"])){
                    
                    
                            
                $effectsInitSession = EffectDB::getById($_POST['selectedEffects']);
                    
                $_SESSION["effectOnChangeName"] = array();
                    
                array_push($_SESSION["effectOnChangeName"] , $effectsInitSession[0]->idEffect);          
                    
            ?> 
            
            <?php } else if (isset($_POST['selectedEffects']) && isset($_SESSION["effectOnChangeName"])) {
                    
                    
                $sessietje = array();
                    
                    
                
                $caughtEffect = EffectDB::getById($_POST['selectedEffects']);                
                
                if(is_array($sessietje)){
                    if(in_array($caughtEffect[0]->idEffect, $_SESSION["effectOnChangeName"])){
                    
                        echo "<script type='text/javascript'>alert('Effect already in the list!');</script>";
                    
                    } else {
                  
                        array_push($_SESSION["effectOnChangeName"] , $caughtEffect[0]->idEffect);  
                    
                    }
                }    
                
                 
                ?>     
            
                
                    
          <?php } ?> 
            
            
            
            
            
            
            
            
            <?php if(isset($_SESSION["causeOnChangeName"]) && !isset($_SESSION["effectOnChangeName"])) { ?>
            <div class="form-check" style="overflow: auto; height: 80%; width: 35%; float: left">
            <h2>Causes</h2>
            
            <?php $sessie = CauseDB::getById($_SESSION["causeOnChangeName"]); ?>
                
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cause</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo 1; ?></td>
                    <td>
                        <input class="form-check-input" type="hidden" name="selectedCauseSession" checked value="<?php echo $sessie[0]->idCause?>" id="<?php echo $sessie[0]->idCause?>">
                        <label class="form-check-label" for="<?php echo $sessie[0]->idCause?>">
                        <?php echo $sessie[0]->CauseName ?>
                        </label>
                    </td>
                </tr>
                </tbody>
            </table>

                
            <h2>Effects (Select minimum 2 effects)</h2>
            <p>No effects selected</p>
            </div>
            <?php } else if(isset($_SESSION["effectOnChangeName"]) && !isset($_SESSION["causeOnChangeName"])) { ?>
            <div class="form-check container" style="overflow: auto; height: 80%; width: 35%; float: left">
            <h2>Causes</h2>
            <p>No cause selected</p>
            
            <h2>Effects (Select minimum 2 effects)</h2>
                
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Effects</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php for($c = 0; $c < count($_SESSION["effectOnChangeName"]); $c++) { 
                 
                $resulteke = EffectDB::getById($_SESSION["effectOnChangeName"][$c]); ?>
                <tr>
                    <td><?php echo $c+1; ?></td>
                    <form method="post" action="insert_Cluster.php">
                    <td>
                        <input class="form-check-input" type="hidden" name="selectedEffectsSession[]" checked value="<?php echo $resulteke[0]->idEffect?>" id="<?php echo $resulteke[0]->idEffect?>">
                        <label class="form-check-label" for="<?php echo $resulteke[0]->idEffect?>">
                            <?php echo $resulteke[0]->EffectName?>
                        </label>
                    </td>
                    <td>
                        <input type="hidden" value="<?php echo $c ?>" name="deleteEffectList">
                        <button type="submit" class="btn btn-danger" name="delete_effectFromList"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                    </td>
                    </form>
                </tr>
                <?php } ?>
                </tbody>
            </table>
                
                      
            </div>
            <?php } else if (isset($_SESSION["effectOnChangeName"]) && isset($_SESSION["causeOnChangeName"])) { ?>
            <div class="form-check container" style="overflow: auto; height: 80%; width: 35%; float: left">
             <h2>Causes</h2>
            
               <?php $sessie = CauseDB::getById($_SESSION["causeOnChangeName"]); ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cause</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo 1; ?></td>
                    <td>
                        <input class="form-check-input" type="hidden" name="selectedCauseSession" checked value="<?php echo $sessie[0]->idCause?>" id="<?php echo $sessie[0]->idCause?>">
                        <label class="form-check-label" for="<?php echo $sessie[0]->idCause?>">
                        <?php echo $sessie[0]->CauseName ?>
                        </label>
                    </td>
                </tr>
                </tbody>
            </table>
                
                
                
                
           
             
            <h2>Effects (Select minimum 2 effects)</h2>
                
                <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Effects</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php for($c = 0; $c < count($_SESSION["effectOnChangeName"]); $c++) { 
                 
                $resulteke = EffectDB::getById($_SESSION["effectOnChangeName"][$c]); ?>
                <tr>
                    <td><?php echo $c+1; ?></td>
                    <form method="post" action="insert_Cluster.php">
                    <td>
                        <input class="form-check-input" type="hidden" name="selectedEffectsSession[]" checked value="<?php echo $resulteke[0]->idEffect?>" id="<?php echo $resulteke[0]->idEffect?>">
                        <label class="form-check-label" for="<?php echo $resulteke[0]->idEffect?>">
                            <?php echo $resulteke[0]->EffectName?>
                        </label>
                    </td>
                    <td>
                        <input type="hidden" value="<?php echo $c ?>" name="deleteEffectList">
                        <button type="submit" class="btn btn-danger" name="delete_effectFromList"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                    </td>
                    </form>
                </tr>
                <?php } ?>
                </tbody>
            </table>
             
                
            
            <?php if(count($_SESSION["effectOnChangeName"]) >= 2) {   ?>    
            <button type="submit" class="btn btn-success" name="insert_ClusterSession" style="margin-top: 8px">Insert</button><br/>
            <button type="submit" class="btn btn-danger" name="unsetSessionsCluster" style="margin-top: 8px">Clear all</button>
            <?php } ?>
            </div>
            <?php } else { ?>
                
            <div class="container" style="overflow: auto; height: 80%; width: 50%; float: left">
            <h1>Clusters</h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cause</th>
                        <th>Effects</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            $clusters = ClusterDB::getAll();
            for($c = 0; $c < count($clusters); $c++){ ?>
                <tr>
                    <td><?php echo $c+1 ?></td>
                    <td><?php $cause = CauseDB::getById($clusters[$c]->Cause_idCause); echo $cause[0]->CauseName;?></td>
                    <?php
                    $arrayEffects = ClusterDB::translateStringToEffects($clusters[$c]->Cluster_Effects);
                    ?>
                    <td><?php
                    $stringEffects = "";
                        foreach ($arrayEffects as $a){
                            $effect = EffectDB::getById((int)$a);
                            $stringEffects .= $effect[0]->EffectName . " | ";
                        }
                        print_r($stringEffects);
                    ?></td>
                </tr>
            <?php } ?>
                </tbody>
            </table>
        </div>
            
            <?php } ?>

        </form>
    
        
            
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="Bootstrap/js/bootstrap.min.js"></script>
<script src="Bootstrap/jquery-3-3-1.js"></script>
<script src="Bootstrap/js/bootstrap.js"></script>
    
    
<script>
$(document).ready(function(){
	load_data();
	function load_data(queryClusterCause)
	{
		$.ajax({
			url:"fetchInsertClusterCause.php",
			method:"post",
			data:{queryClusterCause:queryClusterCause},
			success:function(data)
			{
				$('#resultClusterCause').html(data);
			}
		});
	}
	
	$('#search_textClusterCause').keyup(function(){
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			load_data();			
		}
	});
});
</script>
    
     
<script>
$(document).ready(function(){
	load_data();
	function load_data(queryClusterEffect)
	{
		$.ajax({
			url:"fetchInsertClusterEffect.php",
			method:"post",
			data:{queryClusterEffect:queryClusterEffect},
			success:function(data)
			{
				$('#resultClusterEffect').html(data);
			}
		});
	}
	
	$('#search_textClusterEffect').keyup(function(){
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			load_data();			
		}
	});
});
</script>

</body>

</html>
