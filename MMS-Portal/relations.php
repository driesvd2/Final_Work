<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();

if (isset($_SESSION["deIdVanStatusPageCauseEffect"])) {

    unset($_SESSION["deIdVanStatusPageCauseEffect"]);
}

if (isset($_SESSION['causeOnChangeName']) || isset($_SESSION['effectOnChangeName'])) {

    unset($_SESSION['causeOnChangeName']);
    unset($_SESSION['effectOnChangeName']);
}

if (isset($_SESSION["insertCauseFromInsertCluster"])) {

    unset($_SESSION["insertCauseFromInsertCluster"]);
}

if (isset($_SESSION["insertCauseFromInsertCauseEffect"])) {

    unset($_SESSION["insertCauseFromInsertCauseEffect"]);
}

if (isset($_SESSION["insertCauseFromEditCauseEffect"])) {

    unset($_SESSION["insertCauseFromEditCauseEffect"]);
}

if (isset($_SESSION["insertCauseFromEditCluster"])) {

    unset($_SESSION["insertCauseFromEditCluster"]);
}

error_reporting(E_ERROR | E_PARSE);

include './Database/Forms/Relations/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';



if ($_SESSION['type'] != 0 || !isset($_SESSION['type'])) {
    header('location: login.php');
}


if (isset($_POST['searchCauseOfCauseEffect']) && isset($_POST['causeOrEffectSelectedCauseEffect'])) {

    if ($_POST['causeOrEffectSelectedCauseEffect'] == "effect") {

        $searchqclusEffect = $_POST['searchCauseOfCauseEffect'];

        $searchqclusEffect = preg_replace_callback("#[^0-9a-z]#i", "", $searchqclusEffect);

        $querySearchClusterEffect = EffectDB::getSearchEffectID($searchqclusEffect);

        $resultSearchEffectOfCauseEffect = array();

        foreach ($querySearchClusterEffect as $qe) {

            array_push($resultSearchEffectOfCauseEffect, CauseEffectDB::getCauseEffectWhereIdEffect($qe->id));
        }

    } else if ($_POST['causeOrEffectSelectedCauseEffect'] == "cause") {

        $searchqclus = $_POST['searchCauseOfCauseEffect'];

        $searchqclus = preg_replace_callback("#[^0-9a-z]#i", "", $searchqclus);

        $querySearchCluster = CauseDB::getSearchCauseID($searchqclus);

        $resultSearchCausesOfCauseEffect = array();

        foreach ($querySearchCluster as $q) {
            
            array_push($resultSearchCausesOfCauseEffect, CauseEffectDB::getCauseEffectWhereIdCause($q->id));
        }
 
    } else {

        $searchquery = $_POST['searchCauseOfCauseEffect'];
        $selColEffect = $_POST['causeOrEffectSelectedCauseEffect'];
        
        if($selColEffect == '0'){
            
            $resultSearchCausesOfCauseEffectArray = CauseEffectDB::getAll();
            
        }else{
            
            $searchquery = preg_replace_callback("#[^0-9a-z]#i", "", $searchquery);

            $resultQuerySearchCauseEffect = CauseEffectDB::getSearchCauseOfCauseEffect($searchquery, $selColEffect);
    
            $resultSearchCausesOfCauseEffectArray = array();
    
            foreach ($resultQuerySearchCauseEffect as $result) {
    
                array_push($resultSearchCausesOfCauseEffectArray, $result);
            }
        }
    }
}

if (isset($_POST['searchclusterCause']) && isset($_POST['causeOrEffectSelectedCluster'])) {

    if ($_POST['causeOrEffectSelectedCluster'] == "cause") {

        $searchqcluster = $_POST['searchclusterCause'];

        $searchqcluster = preg_replace_callback("#[^0-9a-z]#i", "", $searchqcluster);

        $queryCauseSearchCluster = CauseDB::getSearchCauseID($searchqcluster);

        $resultSearchCausesOfCluster = array();

        foreach ($queryCauseSearchCluster as $q) {

            array_push($resultSearchCausesOfCluster, ClusterDB::getCauseClusterWhereIdCause($q->id));
        }
        
    } else if ($_POST['causeOrEffectSelectedCluster'] == "effects") {

        $searchqclusterEffect = $_POST['searchclusterCause'];

        $searchqclusterEffect = preg_replace_callback("#[^0-9a-z]#i", "", $searchqclusterEffect);

        $queryEffectSearchCluster = EffectDB::getSearchEffectID($searchqclusterEffect);

        $resultSearchEffectsOfCluster = array();

        foreach ($queryEffectSearchCluster as $q) {


            array_push($resultSearchEffectsOfCluster, ClusterDB::getSearchClusterEffects($q->id));
        }

    } else {

        $searchquery = $_POST['searchclusterCause'];
        $selColCluster = $_POST['causeOrEffectSelectedCluster'];

        if($selColCluster == '0'){
            
            $resultSearchClusterArray = ClusterDB::getAll();
            
        }else{
            
            $searchquery = preg_replace_callback("#[^0-9a-z]#i", "", $searchquery);
            
            $resultQuerySearchCluster = ClusterDB::getSearchCluster($searchquery, $selColCluster);
    
            $resultSearchClusterArray = array();
    
            foreach ($resultQuerySearchCluster as $result) {
    
                array_push($resultSearchClusterArray, $result);
            }
            
        }
    }
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home
                        </a>
                    </li>
                    <li class="nav-item active">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?><span class="sr-only">(current)</span></a>
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
    <?php $getMetaCluster = ClusterDB::getAllColumnsOfCluster(); ?>
    <div class="container" style="width: 50%; float:left;">
    <div class="container">
        <h1>Clusters <a href="insert_Cluster.php" class="greenIcon"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a></h1>
        <form action="relations.php" method="post">
            <div class="wrap">
                <div class="search">
                    <input type="text" class="searchTerm" name="searchclusterCause" placeholder="Filter results...">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <br /><br />
            <div class="select">
                <select name="causeOrEffectSelectedCluster" style="width:120px;">
                <option value="0">---- Filter ----</option>
                    <?php foreach ($getMetaCluster as $meta) { ?>
                        <option value="<?php echo $meta ?>"><?php echo $meta ?></option>
                    <?php } ?>
                </select>
                <a href="manageClusterTable.php" title="Manage cluster metadata" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-cog"></i></a>
            </div>
        </form>
    </div>
    <div class="container" style="height: 60%; float:right; overflow:auto;">
        <?php if (isset($resultSearchCausesOfCluster)) { ?>


            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Effects</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    for ($c = 0; $c < count($resultSearchCausesOfCluster); $c++) {

                        foreach ($resultSearchCausesOfCluster[$c] as $res) {


                            ?>

                            <tr>
                                <td><?php echo $res->id ?></td>
                                <td><?php $cause = CauseDB::getById($res->cause);
                                    echo $cause[0]->name; ?></td>
                                <?php
                                $arrayEffects = ClusterDB::translateStringToEffects($res->effects);
                                ?>
                                <td><?php
                                    $stringEffects = "";
                                    foreach ($arrayEffects as $a) {
                                        $effect = EffectDB::getById((int)$a);
                                        $stringEffects .= $effect[0]->name . " | ";
                                    }
                                    print_r($stringEffects);
                                    ?></td>
                                <td>
                                    <form method="post" action="relations.php">
                                        <input type="hidden" value="<?php echo $res->id ?>" name="Delete_Cluster_id">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="Delete_Cluster"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <a href="edit_cluster.php?id=<?php echo $res->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            </tr>
                        <?php } } ?>
                </tbody>
            </table>

        <?php } else if (isset($resultSearchEffectsOfCluster)) {  ?>


            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Effects</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    for ($c = 0; $c < count($resultSearchEffectsOfCluster); $c++) {

                        foreach ($resultSearchEffectsOfCluster[$c] as $res) {

                            ?>
                            <tr>
                                <td><?php echo $res->id ?></td>
                                <td><?php $cause = CauseDB::getById($res->cause);
                                    echo $cause[0]->name; ?></td>
                                <?php
                                $arrayEffects = ClusterDB::translateStringToEffects($res->effects);
                                ?>
                                <td><?php
                                    $stringEffects = "";
                                    foreach ($arrayEffects as $a) {
                                        $effect = EffectDB::getById((int)$a);
                                        $stringEffects .= $effect[0]->name . " | ";
                                    }
                                    print_r($stringEffects);
                                    ?></td>
                                <td>
                                    <form method="post" action="relations.php">
                                        <input type="hidden" value="<?php echo $res->id ?>" name="Delete_Cluster_id">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="Delete_Cluster"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <a href="edit_cluster.php?id=<?php echo $res->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            </tr>
                        <?php }
                } ?>
                </tbody>
            </table>

        <?php } else if (isset($resultSearchClusterArray)) { ?>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Effects</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php



                    foreach ($resultSearchClusterArray as $res) {

                        ?>
                        <tr>
                            <td><?php echo $res->id ?></td>
                            <td><?php $cause = CauseDB::getById($res->cause);
                                echo $cause[0]->name; ?></td>
                            <?php
                            $arrayEffects = ClusterDB::translateStringToEffects($res->effects);
                            ?>
                            <td><?php
                                $stringEffects = "";
                                foreach ($arrayEffects as $a) {
                                    $effect = EffectDB::getById((int)$a);
                                    $stringEffects .= $effect[0]->name . " | ";
                                }
                                print_r($stringEffects);
                                ?></td>
                            <td>
                                <form method="post" action="relations.php">
                                    <input type="hidden" value="<?php echo $res->id ?>" name="Delete_Cluster_id">
                                    <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="Delete_Cluster"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                </form>
                            </td>
                            <td>
                                <a href="edit_cluster.php?id=<?php echo $res->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>



        <?php } else { ?>


            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Effects</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $clusters = ClusterDB::getAll();
                    for ($c = 0; $c < count($clusters); $c++) { ?>
                        <tr>
                            <td><?php echo $clusters[$c]->id ?></td>
                            <td><?php $cause = CauseDB::getById($clusters[$c]->cause);
                                echo $cause[0]->name; ?></td>
                            <?php
                            $arrayEffects = ClusterDB::translateStringToEffects($clusters[$c]->effects);
                            ?>
                            <td><?php
                                $stringEffects = "";
                                foreach ($arrayEffects as $a) {
                                    $effect = EffectDB::getById((int)$a);
                                    $stringEffects .= $effect[0]->name . " | ";
                                }
                                print_r($stringEffects);
                                ?></td>
                            <td>
                                <form method="post" action="relations.php">
                                    <input type="hidden" value="<?php echo $clusters[$c]->id ?>" name="Delete_Cluster_id">
                                    <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="Delete_Cluster"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                </form>
                            </td>
                            <td>
                                <a href="edit_cluster.php?id=<?php echo $clusters[$c]->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


        <?php } ?>


        </div>
    </div>

    <!--   ------------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <?php $metaColumnsCauseEffect = CauseEffectDB::getAllColumnsOfCauseEffect(); ?>
    <div class="container" style="width: 50%; float:right;">
    <div class="container">
        <h1>Cause - Effect <a href="insert_Cause_Effect.php" class="greenIcon"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a></h1>
        <form action="relations.php" method="post">
            <div class="wrap">
                <div class="search">
                    <input type="text" class="searchTerm" name="searchCauseOfCauseEffect" placeholder="Filter results...">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <br>
            <br>
            <div class="select">
                <select name="causeOrEffectSelectedCauseEffect" style="width:120px;">
                <option value="0">---- Filter ----</option>
                    <?php foreach ($metaColumnsCauseEffect as $metaCE) { ?>
                        <option value="<?php echo $metaCE ?>"><?php echo $metaCE ?></option>
                    <?php } ?>
                </select>
                <a href="manageCause_EffectTable.php" title="Manage cause-effect metadata" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-cog"></i></a>
            </div>
        </form>
        </div>
        <div class="container" style="height: 60%; float:right; overflow:auto;">
        <?php if (isset($resultSearchCausesOfCauseEffect)) { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Effect</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($e = 0; $e < count($resultSearchCausesOfCauseEffect); $e++) {
                        
                            foreach ($resultSearchCausesOfCauseEffect[$e] as $res) {
                    ?>
                            <tr>
                                <td><?php echo $res->id ?></td>
                                <td><?php $cause = CauseDB::getById($res->cause);
                                    echo $cause[0]->name; ?></td>
                                <td><?php $effect = EffectDB::getById($res->effect);
                                    echo $effect[0]->name;  ?></td>
                                <td>
                                    <form method="post" action="relations.php">
                                        <input type="hidden" value="<?php echo $res->id ?>" name="Delete_causeEffect_id">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="Delete_causeEffect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <a href="edit_cause_effect.php?id=<?php echo $res->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            </tr>
                        <?php } } ?>
                </tbody>
            </table>

        <?php } else if (isset($resultSearchEffectOfCauseEffect)) { ?>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Effect</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($e = 0; $e < count($resultSearchEffectOfCauseEffect); $e++) {

                        foreach ($resultSearchEffectOfCauseEffect[$e] as $res) {
                    ?>
                            <tr>
                                <td><?php echo $res->id ?></td>
                                <td><?php $cause = CauseDB::getById($res->cause);
                                    echo $cause[0]->name; ?></td>
                                <td><?php $effect = EffectDB::getById($res->effect);
                                    echo $effect[0]->name;  ?></td>
                                <td>
                                    <form method="post" action="relations.php">
                                        <input type="hidden" value="<?php echo $res->id ?>" name="Delete_causeEffect_id">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="Delete_causeEffect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <a href="edit_cause_effect.php?id=<?php echo $res->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            </tr>
                        <?php }
                } ?>
                </tbody>
            </table>

        <?php } else if (isset($resultSearchCausesOfCauseEffectArray)) { ?>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Effect</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($resultSearchCausesOfCauseEffectArray as $res) { ?>

                        <tr>
                            <td><?php echo $res->id ?></td>
                            <td><?php $cause = CauseDB::getById($res->cause);
                                echo $cause[0]->name; ?></td>
                            <td><?php $effect = EffectDB::getById($res->effect);
                                echo $effect[0]->name;  ?></td>
                            <td>
                                <form method="post" action="relations.php">
                                    <input type="hidden" value="<?php echo $res->id ?>" name="Delete_causeEffect_id">
                                    <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="Delete_causeEffect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                </form>
                            </td>
                            <td>
                                <a href="edit_cause_effect.php?id=<?php echo $res->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                            </td>
                        </tr>
                    <?php } ?>


                </tbody>
            </table>

        <?php } else { ?>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Effect</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $causeEffects = CauseEffectDB::getAll();
                    for ($e = 0; $e < count($causeEffects); $e++) { ?>
                        <tr>
                            <td><?php echo $causeEffects[$e]->id ?></td>
                            <td><?php $cause = CauseDB::getById($causeEffects[$e]->cause);
                                echo $cause[0]->name; ?></td>
                            <td><?php $effect = EffectDB::getById($causeEffects[$e]->effect);
                                echo $effect[0]->name;  ?></td>
                            <td>
                                <form method="post" action="relations.php">
                                    <input type="hidden" value="<?php echo $causeEffects[$e]->id ?>" name="Delete_causeEffect_id">
                                    <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="Delete_causeEffect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                </form>
                            </td>
                            <td>
                                <a href="edit_cause_effect.php?id=<?php echo $causeEffects[$e]->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php } ?>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>

</body>

</html>