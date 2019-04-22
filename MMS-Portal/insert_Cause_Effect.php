<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();

include './Database/Forms/InsertCauseEffect/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';

if($_SESSION['type'] != 0 || !isset($_SESSION['type'])){
        header('location: login.php');
}

if(isset($_SESSION['causeOnChangeName']) || isset($_SESSION['effectOnChangeName'])){
    
    unset($_SESSION['causeOnChangeName']);
    unset($_SESSION['effectOnChangeName']);  
    
}

if(isset($_SESSION["insertCauseFromInsertCluster"])){
    
    unset($_SESSION["insertCauseFromInsertCluster"]);
    
}

if(isset($_SESSION["insertCauseFromInsertCauseEffect"])){
    
    unset($_SESSION["insertCauseFromInsertCauseEffect"]);
    
}

if(isset($_SESSION["insertCauseFromEditCauseEffect"])){
    
    unset($_SESSION["insertCauseFromEditCauseEffect"]);
    
}
 
if(isset($_SESSION["insertCauseFromEditCluster"])){
    
    unset($_SESSION["insertCauseFromEditCluster"]);
    
}

?>

<html style="height: 100%;overflow:hidden">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Final Work">
    <meta name="author" content="Dries Van Dievoort & Stefanos Stoikos">
    <title>
        Final Work - MMS Portal
    </title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="./CSS/custom.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body style="height: 100%;overflow:hidden">
    <nav class="navbar navbar-expand-lg navbar-dark   fixed-top">
        <div class="container">
            <a class="navbar-brand" style="font-weight: bold;" href="index.php">Final Work - MMS Portal</a>
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
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0){ ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?><span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0){ ?>
                            <a class="nav-link" href="manage_status_effect.php"><?php echo 'Status Effect'; ?><span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0){ ?>
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
        <h1>Insert Cause - Effect</h1>
        <?php handleErrorRadioButtons(); ?>
        <?php if (isset($_GET['id'])) {
            $_SESSION["deIdVanStatusPageCauseEffect"] = $_GET['id'];
        }
        ?>
        
        
        <?php $metaColumnsCause = CauseDB::getAllColumnsOfCause(); ?>
        <form method="post" action="insert_Cause_Effect.php">
            <h2>Causes <?php  if(isset($_SESSION['login']) && $_SESSION['type'] == 0){   ?>
            <a href="insert_Cause.php?clickedOnCauseEffect=insertCauseEffect" class="greenIcon"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a>
            <?php } ?></h2>
            <div class="wrap" style="height: 25px">
                <div class="search">
				    <div class="input-group">
					   <input type="text" class="searchTermAjax" name="search_text" id="search_text" placeholder="Filter Causes" class="form-control" />
				    </div>
			    </div>
            </div>
            <br>
            <br>
            <div class="select">
            <label></label>
            <select id="columnSelectCauseOfCauseEffect" name="search_selectCauseColumn" style="width:120px;">
            <option value="name">---- Filter ----</option>
                        <?php foreach($metaColumnsCause as $metaSelect) { ?>
                        <option value="<?php echo $metaSelect; ?>"><?php echo $metaSelect; ?></option>
                        <?php } ?>
            </select>
            </div>
        
    <div id="result" class="container" style="float: left; overflow: auto; height: 20%; margin-top: 8px; margin-bottom: 8px"></div>
            
            <?php if(isset($_SESSION["deIdVanStatusPageCauseEffect"])) { 
                
            $sessieRedirectStatusEffect = EffectDB::getById($_SESSION["deIdVanStatusPageCauseEffect"]); ?>
            <h2>Effects</h2>
                <div class="form-check">
                <input class="form-check-input" type="radio" checked name="Effect" value="<?php echo $sessieRedirectStatusEffect[0]->id ?>" id="<?php echo $sessieRedirectStatusEffect[0]->id ?>">
                 <label class="form-check-label" for="<?php echo $sessieRedirectStatusEffect[0]->id ?>">
                            <?php echo $sessieRedirectStatusEffect[0]->name; ?>
                        </label><br/>
                </div>
             <?php } else { ?>
            
            <h2>Effects</h2>
            <?php $metaColumnsEffect = EffectDB::getAllColumnsOfEffect(); ?>
            <div class="wrap" style="height: 25px">
                <div class="search">
				    <div class="input-group">
					   <input type="text" class="searchTermAjax" name="search_textEffect" id="search_textEffect" placeholder="Filter Effects" class="form-control" />
				    </div>
			    </div>
            </div>
            <br/>
            <br/>
            <div class="select">
            <label></label>
            <select id="columnSelectEffectOfCauseEffect" name="search_selectEffectColumn" style="width:120px;">
            <option value="name">---- Filter ----</option>
                        <?php foreach($metaColumnsEffect as $metaSelectEff) { ?>
                        <option value="<?php echo $metaSelectEff; ?>"><?php echo $metaSelectEff; ?></option>
                        <?php } ?>
            </select>
            </div>
    <div id="resultEffect" class="container" style="float: left; overflow: auto; height: 20%; margin-top: 8px; margin-bottom: 8px"></div>

            <?php } ?>
            
            <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="insert_CauseEffect" style="padding-top: 500000px;">Insert</button>
            <?php if(isset($_SESSION["deIdVanStatusPageCauseEffect"])) { ?>
                <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="unsetSessionsCauseEffect" style="margin-top: 8px">Cancel</button>
            <?php  } ?>
        </form>
        
    </div>
    
   

    <div class="container" style="overflow: auto; height: 80%; width: 50%; float: left">
        <h1>Cause - Effect</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cause</th>
                    <th>Effect</th>
                </tr>
            </thead>
            <tbody>
            <?php $causeEffects = CauseEffectDB::getAll();
            for ($e = 0; $e < count($causeEffects); $e++){ ?>
                <tr>
                    <td><?php echo $causeEffects[$e]->id?></td>
                    <td><?php $cause = CauseDB::getById($causeEffects[$e]->cause); echo $cause[0]->name; ?></td>
                    <td><?php $effect = EffectDB::getById($causeEffects[$e]->effect); echo $effect[0]->name;  ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="Bootstrap/js/bootstrap.min.js"></script>
               <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>
            
<script>
$(document).ready(function(){
	load_data();
	function load_data(query, columnSearch)
	{
		$.ajax({
			url:"fetch.php",
			method:"post",
			data:{query:query, columnSearch:columnSearch},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}
	
	$('#search_text').keyup(function(){
		var search = $(this).val();
        var e = document.getElementById("columnSelectCauseOfCauseEffect");
        var valueCauseColumn = e.options[e.selectedIndex].value;
        
		if(search != '')
		{
			load_data(search, valueCauseColumn);
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
	function load_data(queryEffect, columnSearchEffect)
	{
		$.ajax({
			url:"fetchInsertCauseEffect.php",
			method:"post",
			data:{queryEffect:queryEffect, columnSearchEffect:columnSearchEffect},
			success:function(data)
			{
				$('#resultEffect').html(data);
			}
		});
	}
	
	$('#search_textEffect').keyup(function(){
		var search = $(this).val();
        var e = document.getElementById("columnSelectEffectOfCauseEffect");
        var valueEffectColumn = e.options[e.selectedIndex].value;
		if(search != '')
		{
			load_data(search, valueEffectColumn);
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
