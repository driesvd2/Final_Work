<?php 
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

if(isset($_SESSION["insertCauseFromEditCauseEffect"])){
    
    unset($_SESSION["insertCauseFromEditCauseEffect"]);
    
}

if(isset($_SESSION["insertCauseFromEditCluster"])){
    
    unset($_SESSION["insertCauseFromEditCluster"]);
    
}

error_reporting(E_ERROR | E_PARSE);

if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['login']);
    unset($_SESSION['type']);
    header("location: index.php");
}

include 'Database/Forms/AlterTableCause/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';
include_once "./Database/DatabaseFactory.php";

function getVerbinding() {
        return DatabaseFactory::getDatabase();
}

function getAllTableNames() {
        $resultaat = getVerbinding()->voerSqlQueryUit("SELECT table_name FROM information_schema.tables where table_schema= '1819FW_DRIESD_STEFANOSS'");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
                $result = $resultaat->fetch_array();
                $resultatenArray[$index] = $result["table_name"];
            }
        return $resultatenArray;
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
    <link rel="stylesheet" href="./CSS/custom.css">    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./CSS/custom.css">
     
</head>

<body style="height: 100%;overflow:hidden">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" style="font-weight: bold;" href="index.php">Final Work - MMS Portal</a>
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
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 1){ ?>
                            <a class="nav-link" href="webservicePage.php"><?php echo 'Search'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0){ ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['type'] == 0){ ?>
                            <a class="nav-link" href="manage_status_effect.php"><?php echo 'Status Effect'; ?></a>
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
    
    <div class="container" style="width: 50%; float: left; height: 80%; overflow:auto">
        <h1>Add row to table cause</h1> 
        <form method="post" action="manageTables.php">
            <div class="form-group">
                <input class="col-lg-4" type="text" name="postTest"><br><br>
                <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="submitPost">Submit</button>
            </div>
        </form>    
    </div>
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="../../../Users/Dries/Downloads/Final_Work_Frontend/Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>
    
</body>

</html>
