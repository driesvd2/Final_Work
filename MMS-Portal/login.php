<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 25/01/2019
 * Time: 01:32
 */

session_start();

include 'Database/Forms/Login - Registreer/server.php';

//if($_SESSION['userType'] != null || $_SESSION['userType'] == 0 || $_SESSION['userType'] == 1){
//        header('location: NoPermissionPage.php');
//}

//if($_SESSION['userType'] != 0 || !isset($_SESSION['userType'])){
//        header('location: NoPermissionPage.php');
//}


?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Final Work">
    <meta name="author" content="Dries Van Dievoort & Stefanos Stoikos">
    <title>
        Final Work - MMS DB Acces
    </title>
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){ ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){ ?>
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