<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:07
 */

session_start();

if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['login']);
    unset($_SESSION['userType']);
    header("location: index.php");
}

include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ErrorDB.php';
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
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){ ?>
                            <a class="nav-link" href="admin.php"><?php echo 'Admin'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 1){ ?>
                            <a class="nav-link" href="insert.php"><?php echo 'Insert'; ?></a>
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
            <h1>Causes</h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cause</th>
                    </tr>
                </thead>
                <tbody>
            <?php $causes = CauseDB::getAll();
            for($c = 0; $c < count($causes); $c++){ ?>
                <tr>
                    <td><?php echo $c+1 ?></td>
                    <td><?php echo $causes[$c]->CauseName ?></td>
                </tr>
            <?php } ?>
                </tbody>
            </table>
    </div>
    <div class="container" style="width: 50%; float: left">
        <h1>Effects</h1>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Cause</th>
            </tr>
            </thead>
            <tbody>
            <?php $effects = EffectDB::getAll();
            for ($e = 0; $e < count($effects); $e++){ ?>
                <tr>
                    <td><?php echo $e + 1 ?></td>
                    <td><?php echo $effects[$e]->EffectName ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
