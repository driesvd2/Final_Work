<?php

ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();

if(isset($_SESSION["deIdVanStatusPageCauseEffect"])){
    
    unset($_SESSION["deIdVanStatusPageCauseEffect"]);
    
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

if(isset($_SESSION["insertCauseFromEditCluster"])){
    
    unset($_SESSION["insertCauseFromEditCluster"]);
    
}

include './Database/Forms/InsertEffectAdmin/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';

if($_SESSION['type'] != 0 || !isset($_SESSION['type'])){
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
<link rel="stylesheet" href="./CSS/custom.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0){ ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
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

    <div class="container" style="width: 50%; float: left">
        <h1>Insert Effect</h1>
        <p>Check if the Effect is not already listed on the right</p>
        <form method="post" action="insert_effect_admin.php">
            <div class="form-group">
                <label for="Effect">Effect: </label>
                <input type="text" class="form-control" id="Effect" name="name" placeholder="Enter Effect..." required>
            </div>
            <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="insert_effect_admin">Insert</button>
        </form>
    </div>
    <h1>Effects</h1>
    <div class="container" style="width: 50%; float: left; height: 75%;overflow:auto">
        
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Effect</th>
            </tr>
            </thead>
            <tbody>
            <?php $effects = EffectDB::getAll();
            for ($e = 0; $e < count($effects); $e++){ ?>
                <tr>
                    <td><?php echo $effects[$e]->id ?></td>
                    <td><?php echo $effects[$e]->name ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="../../../Users/Dries/Downloads/Final_Work_Frontend/Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>
    
</body>

</html>