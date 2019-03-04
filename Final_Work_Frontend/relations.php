<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 23/02/2019
 * Time: 16:47
 */

session_start();

include './Database/Forms/Relations/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ErrorDB.php';
include_once './Database/DAO/ClusterDB.php';
?>

<html style="height: 100%; overflow: hidden">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Final Work">
    <meta name="author" content="Dries Van Dievoort & Stefanos Stoikos">
    <title>
        Final Work - MMS DB Acces
    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body style="height: 100%; overflow: hidden">
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

        <div class="container" style="overflow: auto; height: 90%; width: 50%; float: left">
            <h1>Clusters <a href="insert_Cluster.php"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a></h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cause</th>
                        <th>Effects</th>
                        <th>Delete</th>
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
                    <td>
                        <form method="post" action="relations.php">
                            <input type="hidden" value="<?php echo $clusters[$c]->idCluster?>" name="Delete_Cluster_id">
                            <button type="submit" class="btn btn-danger" name="Delete_Cluster"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
                </tbody>
            </table>
        </div>

    <div class="container" style="width: 50%; float: left;overflow: auto; height: 90%;">
        <h1>Cause <-> Effect  <a href="insert_Cause_Effect.php"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a></h1>
        <table class="table table-bordered table-hover" >
            <thead>
            <tr>
                <th>#</th>
                <th>Cause</th>
                <th>Effect</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php $causeEffects = CauseEffectDB::getAll();
            for ($e = 0; $e < count($causeEffects); $e++){ ?>
                <tr>
                    <td><?php echo $e + 1?></td>
                    <td><?php $cause = CauseDB::getById($causeEffects[$e]->Cause_idCause); echo $cause[0]->CauseName; ?></td>
                    <td><?php $effect = EffectDB::getById($causeEffects[$e]->Effect_idEffect); echo $effect[0]->EffectName;  ?></td>
                    <td>
                        <form method="post" action="relations.php">
                            <input type="hidden" value="<?php echo $causeEffects[$e]->id?>" name="Delete_causeEffect_id">
                            <button type="submit" class="btn btn-danger" name="Delete_causeEffect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="Bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
