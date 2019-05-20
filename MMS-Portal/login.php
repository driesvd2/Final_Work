<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
error_reporting(E_ERROR | E_PARSE);
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

if(isset($_SESSION["insertCauseFromEditCauseEffect"])){
    
    unset($_SESSION["insertCauseFromEditCauseEffect"]);
    
}

if(isset($_SESSION["insertCauseFromEditCluster"])){
    
    unset($_SESSION["insertCauseFromEditCluster"]);
    
}

include 'Database/Forms/Login - Registreer/server.php';

//if($_SESSION['type'] != null || $_SESSION['type'] == 0 || $_SESSION['type'] == 1){
//        header('location: NoPermissionPage.php');
//}

//if($_SESSION['type'] != 0 || !isset($_SESSION['type'])){
//        header('location: NoPermissionPage.php');
//}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Final Work">
    <meta name="author" content="Dries Van Dievoort & Stefanos Stoikos">
    <title>
        Final Work - MMS Portal
    </title>
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/custom.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark   fixed-top">
        <div class="container">
            <a class="navbar-brand" style="font-weight: bold;" href="index.php">Final Work - MMS Portal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                    <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0 || $_SESSION['type'] == 1){ ?>
                        <a class="nav-link" href="index.php">Home</a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0){ ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="manage_status_effect.php"><?php echo 'Status Effect'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0){ ?>
                            <a class="nav-link" href="manageUser.php"><?php echo 'User Management & Webservice'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item active">
                        <?php if (isset($_SESSION['login'])){ ?>
                        <a class="nav-link" href="index.php?logout='1'">Logout<span class="sr-only">(current)</span></a>
                        <?php }
                        else{ ?>
                        <a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>
                        <?php }?>
                    </li>
                </ul>
            </div>
        </div>
</nav>
    
    <br>
    <br>
    <br>
    <div class="container" style="width: 75%">
        <h1 style="font-weight: bold;">Login</h1>
            <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="username">Username: </label>
                        <input type="text" class="form-control" id="username" name="log_username" placeholder="Enter username...">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password: </label>
                        <input type="password" class="form-control" id="pwd" name="log_paswoord" placeholder="Enter password...">
                    </div>
                    <button type="submit" class="btn" name="login_gebruiker">Login</button>
            </form>
    </div>
</body>
</html>