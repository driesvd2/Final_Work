<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);

session_start();

error_reporting(E_ERROR | E_PARSE);

include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseTagDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
 

if ($_SESSION['type'] != 0 || !isset($_SESSION['type'])) {
    header('location: login.php');
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./CSS/custom.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./CSS/custom.css">
</head>

<body style="height: 100%;overflow:auto">
    <nav class="navbar navbar-expand-lg navbar-dark   fixed-top">
        <div class="container">
            <a class="navbar-brand" style="font-weight: bold;" href="index.php">Final Work - MMS Portal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="manage_status_effect.php"><?php echo 'Status Effect'; ?><span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="manageUser.php"><?php echo 'User Management & Webservice'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['login'])) { ?>
                            <a class="nav-link" href="index.php?logout='1'">Logout</a>
                        <?php } else { ?>
                            <a class="nav-link" href="login.php">Login</a>
                        <?php } ?>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br>
    <br>
    <br>
    
    
    <?php
    
    function showErrorUsedTagDelete(){
        echo '<span style="color:red; padding-left:51.5%;" >This tag is used by a cause</span>';
    }
    
    function showErrorNoNameFilled(){
        echo '<span style="color:red; padding-left:51.5%;" >Please enter a category name</span>';
    }
    
    function showErrorNameAlreadyExists(){
        echo '<span style="color:red; padding-left:51.5%;" >This Category name already exists</span>';
    }
    
    if(isset($_POST['insert_CauseTag']) && $_POST['name'] == null){
        
        showErrorNoNameFilled();
        
    }
    
    if(isset($_POST['insert_CauseTag']) && $_POST['name'] != null){
        
        if(CauseTagDB::getSearchTagID($_POST['name'])){
            showErrorNameAlreadyExists();
        }else {
            
            if (empty($_POST['tag']) || $_POST['tag'] == null || is_null($_POST['tag'])) {
            CauseTagDB::insertNull($_POST['name']);
            }else{
                CauseTagDB::insert($_POST['name'], $_POST['tag']);
            }
            
        }
        
        
    }
     
    
    
    if(isset($_POST['delete_causetag']) && isset($_POST['delete_idtag'])){
        
        if(CauseDB::getAllWhereTag($_POST['delete_idtag'])){
            
            showErrorUsedTagDelete();
            
        }else{
            CauseTagDB::deleteById($_POST['delete_idtag']);
        }
    }
    
    if(isset($_POST['changeTagName']) && isset($_POST['textToChange']) && isset($_POST['updateIdTag']) && $_POST['textToChange'] != null){
        
        CauseTagDB::changeNameTag($_POST['textToChange'], $_POST['updateIdTag']);
        
    }
    
    ?>
    
     
    <?php 
        $firstTags = CauseTagDB::getAllFirst();
        $secondTags = CauseTagDB::getAllSecond();
        $thirdTags = CauseTagDB::getAllThird();
    ?>
    
<form method="post" action="insert_CauseTag.php">
    <div class="container" style="width: 50%; float: left;">
        <h1>Insert Cause Category</h1>
        <p>Check if the Category is not already listed on the right.</p>
        
            <div class="form-group">
                <label for="CauseTag">Category: </label>
                <input type="text" class="form-control" id="CauseTag" name="name" placeholder="Enter Category...">
            </div>
            <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="insert_CauseTag">Insert</button>
        
    </div>

    <div class="container" style="width: 50%;float: left;">
        <div class="container">
            <h1>All Categories</h1>
            <h6>Choose a parent category for your category</h6>
             
        </div>    
        <div class="container" style="float: left; height: 60%;overflow:auto">
            <table class="table table-bordered table-hover" >
            <thead>
                <tr>
                    <th width="2%"></th>
                    <th width="20%">Category</th>
                    <th width="10%">Parent</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($firstTags as $t){  ?>
                    <tr>
                        <td><input type="radio" name="tag" value="<?php echo $t->id ?>"></td>
                        <form method="post" action="insert_CauseTag.php">
                        <td> 
                            <input type="hidden" value="<?php echo $t->id ?>" name="updateIdTag">
                            <input type="text" class="form-control" style="width:70%; float: left; margin-right: 2px" name="textToChange" value="<?php echo $t->name ?>">
                            <button type="submit" name="changeTagName" class="btn btn-primary" style="background-color: #223A50; margin-top: 2px;"><i class="fa fa-edit" style="font-size: 20px;"></i></button>
                        </td>
                        <td><?php echo "No parent" ?></td>
                        <?php if(CauseTagDB::ifLast($t->id)){ ?>
                            <input type="hidden" value="<?php echo $t->id ?>" name="delete_idtag">
                            <td><button type="submit" class="btn btn-danger" style="background-color: #DA291C;" style="background-color: #DA291C;" name="delete_causetag"><i class="fa fa-trash" style="font-size: 20px;"></i></button></td>  
                        <?php } else { ?>
                            <td><p>Not Available</p></td>
                        <?php } ?>  
                        </form>
                    </tr>
                    <?php foreach($secondTags as $s){ 
                        if($s->parent == $t->id){?>
                    <tr>  
                        <td><input type="radio" name="tag" value="<?php echo $s->id ?>"></td>
                        <form method="post" action="insert_CauseTag.php">
                        <td>
                            <input type="hidden" value="<?php echo $s->id ?>" name="updateIdTag">
                            <input type="text" class="form-control" style="width:70%; float: left; margin-right: 2px" name="textToChange" value="<?php echo $s->name ?>">
                            <button type="submit" name="changeTagName" class="btn btn-primary" style="background-color: #223A50; margin-top: 2px;"><i class="fa fa-edit" style="font-size: 20px;"></i></button>
                        </td>
                        <td><?php echo $t->name ?></td>
                        <?php if(CauseTagDB::ifLast($s->id)){ ?>
                            <input type="hidden" value="<?php echo $s->id ?>" name="delete_idtag">
                            <td><button type="submit" class="btn btn-danger" style="background-color: #DA291C;" style="background-color: #DA291C;" name="delete_causetag"><i class="fa fa-trash" style="font-size: 20px;"></i></button></td>  
                        <?php } else { ?>
                            <td><p>Not Available</p></td>
                        <?php } ?>
                        </form>
                    </tr>
                    <?php foreach($thirdTags as $th){ 
                        if($th->parent == $s->id){?>
                    <tr> 
                        <td><input type="radio" disabled></td>
                        <form method="post" action="insert_CauseTag.php">
                        <td>
                            <input type="hidden" value="<?php echo $th->id ?>" name="updateIdTag">
                            <input type="text" class="form-control" style="width:70%; float: left; margin-right: 2px" name="textToChange" value="<?php echo $th->name ?>">
                            <button type="submit" name="changeTagName" class="btn btn-primary" style="background-color: #223A50; margin-top: 2px;"><i class="fa fa-edit" style="font-size: 20px;"></i></button>
                        </td>
                        <td><?php echo $s->name ?></td>
                        <input type="hidden" value="<?php echo $th->id ?>" name="delete_idtag">
                        <td><button type="submit" class="btn btn-danger" style="background-color: #DA291C;" style="background-color: #DA291C;" name="delete_causetag"><i class="fa fa-trash" style="font-size: 20px;"></i></button></td>
                        </form>
                    </tr>
                <?php }}}}} ?>
                 
            </tbody>
        </table> 
        </div>               
     </div> 
</form> 

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../../../Users/Dries/Downloads/Final_Work_Frontend/Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>


</body>

</html>