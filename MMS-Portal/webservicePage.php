<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 24/02/2019
 * Time: 11:48
 */

session_start();

include './Database/Forms/WebserviceForm/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ErrorDB.php';
include_once './Database/DAO/ClusterDB.php';



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
    
    
    
   //$_SESSION['effectOnChangeName'] = array_splice($_SESSION['effectOnChangeName'], 0, 1 ,$_POST["deleteEffectList"]);
    
    unset($_SESSION['effectOnChangeNameWeb'][$_POST["deleteEffectList"]]);
    
     
    $_SESSION['effectOnChangeNameWeb'] = array_values($_SESSION['effectOnChangeNameWeb']);
   
   
    
    
    
}



?>

<?php $counter = 1; ?>

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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 1){ ?>
                            <a class="nav-link" href="webservicePage.php"><?php echo 'Search'; ?><span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item active">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){ ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){ ?>
                            <a class="nav-link" href="manage_status_effect.php"><?php echo 'Status Effect'; ?></a>
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

    <div class="container" style="width: 50%; float: left; height: 150%; ">
                
        <form method="post" action="webservicePage.php" onchange="this.form.submit()">            
            
            <h2>Effects</h2>
            
            <div class="wrap" style="height: 25px">
                <div class="search">
				    <div class="input-group">
					   <input type="text" class="searchTerm" name="search_textWebservice" id="search_textWebservice" placeholder="Filter Effects" class="form-control" />
				    </div>
			    </div>
            </div>
            <br/>
            <div id="resultWebserviceSearch" class="container" style="float: left; overflow: auto; height: 20%; margin-top: 8px; margin-bottom: 8px"></div>
            
            
        </form>
    </div>
    
    
    
    
    
    

        <form method="post" action="webservicePage.php">

            <?php  
    
                if(isset($_POST['selecEffect']) && !isset($_SESSION["effectOnChangeNameWeb"])){
           
                $effectsInitSession = EffectDB::getById($_POST['selecEffect']);
                    
                $_SESSION["effectOnChangeNameWeb"] = array();
                    
                array_push($_SESSION["effectOnChangeNameWeb"] , $effectsInitSession[0]->idEffect);          
                    
            ?> 
            
            <?php } else if (isset($_POST['selecEffect']) && isset($_SESSION["effectOnChangeNameWeb"])) {
                    
                    
                $sessietje = array();
                    
                    
                
                $caughtEffect = EffectDB::getById($_POST['selecEffect']);                
                
                if(is_array($sessietje)){
                    if(in_array($caughtEffect[0]->idEffect, $_SESSION["effectOnChangeNameWeb"])){
                    
                        echo "<script type='text/javascript'>alert('Effect already in the list!');</script>";
                    
                    } else {
                  
                        array_push($_SESSION["effectOnChangeNameWeb"] , $caughtEffect[0]->idEffect);  
                    
                    }
                }    
                
                 
                ?>     
            
                
                    
          <?php } ?> 
            
            
            <?php if(!isset($_SESSION["effectOnChangeNameWeb"]) && !isset($_SESSION["catchedCause"])) { ?>
            <div class="form-check container" style="overflow: auto; height: 80%; width: 35%; float: left">
                   <h2>Selected effects</h2>
                   <p>No effects selected</p> 
            </div>
            <?php } else if (isset($_SESSION["effectOnChangeNameWeb"]) && !isset($_SESSION["catchedCause"])) { ?>
            
            
            <div class="form-check container" style="overflow: auto; height: 80%; width: 35%; float: left">      
             
            <h2>Selected effects</h2>
                
                
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Effects</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php for($c = 0; $c < count($_SESSION["effectOnChangeNameWeb"]); $c++) { 
                 
                $resulteke = EffectDB::getById($_SESSION["effectOnChangeNameWeb"][$c]); ?>
                <tr>
                    <td><?php echo $c+1; ?></td>
                    <form method="post" action="webservicePage.php">
                    <td>
                        <input class="form-check-input" type="hidden" name="selectedEffectsSessionWeb[]" checked value="<?php echo $resulteke[0]->idEffect?>" id="<?php echo $resulteke[0]->idEffect?>">
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
                
            
            <?php if(count($_SESSION["effectOnChangeNameWeb"]) >= 2) {   ?>    
            <button type="submit" class="btn btn-success" name="sendForWebservice" style="margin-top: 8px">Insert</button><br/>
            <button type="submit" class="btn btn-danger" name="unsetSessionsWebservice" style="margin-top: 8px">Clear all</button>
            <?php } ?>
            </div>
            
            
            <?php } else if(isset($_SESSION["catchedCause"])) { ?>
            
                <?php if($_SESSION["catchedCause"] == null) { ?>
                    <div class="form-check container" style="overflow: auto; height: 80%; width: 35%; float: left">
                    <p>Try again, no causes catched...</p>
                    <button type="submit" class="btn btn-primary" name="new_search_webservice">New search</button>
                    </div>
                <?php } else { ?>
            <div class="form-check container" style="overflow: auto; height: 80%; width: 35%; float: left">
                
                <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Catched causes</th>
                    </tr>
                </thead>
                    <tbody>
           <?php foreach($_SESSION["catchedCause"] as $deGecatcheteCause) {    ?>
                <tr>
                    <td>
                        <?php echo $counter++; ?>
                    </td>
                    <td>
                        <label class="form-check-label" for="<?php echo $deGecatcheteCause[0]->idCause ?>">
                            <?php echo $deGecatcheteCause[0]->CauseName?>
                        </label>
                    </td>
                </tr>
            <?php } ?>
                 </tbody>
                </table>
               <button type="submit" class="btn btn-primary" name="new_search_webservice">New search</button>
            </div>
            <?php } } ?>
        </form>
    
         
        
            
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="Bootstrap/js/bootstrap.min.js"></script>
<script src="Bootstrap/jquery-3-3-1.js"></script>
<script src="Bootstrap/js/bootstrap.js"></script>
    
<script>
$(document).ready(function(){
	load_data();
	function load_data(queryWebservice)
	{
		$.ajax({
			url:"fetchWebservice.php",
			method:"post",
			data:{queryWebservice:queryWebservice},
			success:function(data)
			{
				$('#resultWebserviceSearch').html(data);
			}
		});
	}
	
	$('#search_textWebservice').keyup(function(){
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
