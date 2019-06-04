<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
error_reporting(E_ERROR | E_PARSE);
include './Database/Forms/UpdateCluster/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';

//if(isset($_SESSION["deIdVanStatusPageCauseEffect"])){
//    
//    unset($_SESSION["deIdVanStatusPageCauseEffect"]);
//    
//}
//
//if(isset($_SESSION["insertCauseFromInsertCluster"])){
//    
//    unset($_SESSION["insertCauseFromInsertCluster"]);
//    
//}
//
//if(isset($_SESSION["insertCauseFromInsertCauseEffect"])){
//    
//    unset($_SESSION["insertCauseFromInsertCauseEffect"]);
//    
//}

//if(isset($_SESSION["insertCauseFromEditCluster"])){
//    
//    unset($_SESSION["insertCauseFromEditCluster"]);
//    
//}

 
// OFWEL KIEZEN VOOR DIT UIT COMMENT MAAR ALS JE DIT DOET DAN KAN JE NIET MEER TERUG OP EDIT CLUSTER ALS JE EEN CAUSE WIL TOEVOEGEN VANUIT EDIT_CLUSTER.PHP
//if (!isset($_GET['id'])) {
// 
//    header('location: relations.php');
//    
//} 
 
$variable = 0;
if ($_SESSION['type'] != 0 || !isset($_SESSION['type'])) {
    header('location: login.php');
}





if (isset($_POST['cause'])) {
    $_SESSION['causeClusterObjEdit'] = CauseDB::getByIdMeta($_POST['cause']);
    $variable = 1;
}

if (isset($_GET['id']) && !ctype_space($_GET['id']) && !empty($_GET['id']) && ClusterDB::getByIdMeta($_GET['id']) != null || $variable == 1) {
    $variable = 1;
} else if ($variable == 1) {
    $variable = 1;
} 

if (isset($_POST['searchCause']) && !empty($_POST['searchCause'])) {

    $searchqf = $_POST['searchCause'];

    $searchqf = preg_replace_callback("#[^0-9a-z]#i", function ($found) {
        return strtolower($found[1]);
    }, $searchqf);

    $querySearchCauseInsertCluster = CauseDB::getSearchCause($searchqf);
}

if (isset($_POST['searchEffectCluster']) && !empty($_POST['searchEffectCluster'])) {

    $searchquery = $_POST['searchEffectCluster'];

    $searchquery = preg_replace_callback("#[^0-9a-z]#i", function ($found) {
        return strtolower($found[1]);
    }, $searchquery);

    $querySearchEffectInsertCluster = EffectDB::getSearchEffectWhereStatusNotZero($searchquery);
}

if (isset($_POST["deleteEffectListEdit"]) && isset($_POST["delete_effectFromListEdit"])) {

    unset($_SESSION['effectsClusterOfObjEdit'][$_POST["deleteEffectListEdit"]]);

    $_SESSION['effectsClusterOfObjEdit'] = array_values($_SESSION['effectsClusterOfObjEdit']);
}

if (isset($_GET['id'])  && !ctype_space($_GET['id']) && !empty($_GET['id'])) {

    $_SESSION['clusterObjEdit'] = ClusterDB::getByIdMeta($_GET['id']);

    $_SESSION['causeClusterObjEdit'] = CauseDB::getByIdMeta($_SESSION['clusterObjEdit']['cause']);

    $_SESSION['effectsClusterOfObjEdit'] = array();

    foreach (ClusterDB::translateStringToEffects($_SESSION['clusterObjEdit']['effects']) as $theTranslation) {

        array_push($_SESSION['effectsClusterOfObjEdit'], $theTranslation);
    }
}


/*if (!isset($_GET['id']) && ClusterDB::getByIdMeta($_GET['id']) == null && $variable != 1) {
    header('location: relations.php');
}*/




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

    <div class="container" style="width: 50%; float: left; height: 80%;">
        <h1>Edit Cluster</h1>
        <?php include './Database/Forms/UpdateCluster/server.php'; ?>
        <?php $metaColumnsCause = CauseDB::getAllColumnsOfCause(); ?>
        <?php $metaColumnsEffect = EffectDB::getAllColumnsOfEffect(); ?>
        <?php 
                if (isset($_POST['effect'])) {
                    $sessietje = array();
                    $tempVarPostEffectClusterClick = EffectDB::getByIdMeta($_POST['effect']);
                    if (is_array($sessietje)) {
                        if (in_array($tempVarPostEffectClusterClick['id'], $_SESSION["effectsClusterOfObjEdit"])) {
                            echo '<span style="color:red;">The effect is already in the list!</span>';
                        } else {
                            array_push($_SESSION['effectsClusterOfObjEdit'], $tempVarPostEffectClusterClick['id']);
                        }
                    }
                    $variable = 1;
                }
                
                ?>
        <form method="post" action="edit_cluster.php" onchange="this.form.submit()">
            <h2>Causes <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                    <a href="insert_Cause.php?clickedOnEditCluster=editCluster&id=<?php echo $_SESSION['clusterObjEdit']['id'] ?>" class="greenIcon"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a>
                <?php } ?></h2>


            <div class="wrap" style="height: 20px">
                <div class="search">
                    <div class="input-group">
                        <input type="text" class="searchTermAjax" name="search_textClusterEditCause" id="search_textClusterEditCause" placeholder="Filter Causes" class="form-control" />
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="select">
                <label></label>
                <select id="columnSelectCauseOfClusterEdit" name="search_selectCauseColumnEdit" style="width:120px;">
                    <option value="name">---- Filter ----</option>
                    <?php foreach ($metaColumnsCause as $metaSelect) { ?>
                        <option value="<?php echo $metaSelect; ?>"><?php echo $metaSelect; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div id="resultClusterEditCause" class="container" style="float: left; overflow: auto; height: 15%; margin-top: 8px; margin-bottom: 8px"></div>


            <h2>Effects</h2>

            <div class="wrap" style="height: 20px">
                <div class="search">
                    <div class="input-group">
                        <input type="text" class="searchTermAjax" name="search_textClusterEffect" id="search_textClusterEffect" placeholder="Filter Effects" class="form-control" />
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="select">
                <label></label>
                <select id="columnSelectEffectOfClusterEdit" name="search_selectEffectColumnEdit" style="width:120px;">
                    <option value="name">---- Filter ----</option>
                    <?php foreach ($metaColumnsEffect as $metaSelect) { ?>
                        <option value="<?php echo $metaSelect; ?>"><?php echo $metaSelect; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div id="resultClusterEditEffect" class="container" style="float: left; overflow: auto; height: 15%; margin-top: 8px; margin-bottom: 8px"></div>


        </form>
    </div>






    <?php $clusterMetaData = ClusterDB::getAllMetaColumnsOfCluster(); ?>
    <form method="post" action="edit_cluster.php">

        <?php if (isset($_SESSION["effectsClusterOfObjEdit"]) && isset($_SESSION["causeClusterObjEdit"])) { ?>
            <div class="form-check container" style="overflow: auto; height: 70%; width: 50%; float: left;">

                <input class="form-check-input" type="hidden" name="id" value="<?php echo $_SESSION['clusterObjEdit']['id'] ?>" id="<?php echo $_SESSION['clusterObjEdit']['id'] ?>">

                <h2>Causes</h2>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cause</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td><?php echo $_SESSION["causeClusterObjEdit"]['id']; ?></td>
                            <td>
                                <input class="form-check-input" type="hidden" name="selCause" checked value="<?php echo $_SESSION["causeClusterObjEdit"]['id']; ?>" id="<?php echo $_SESSION["causeClusterObjEdit"]['id']; ?>">
                                <label class="form-check-label" for="<?php echo $_SESSION["causeClusterObjEdit"]['id']; ?>">
                                    <?php echo $_SESSION["causeClusterObjEdit"]['name']; ?>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h2>Effects (Select minimum 2 effects)</h2>
                
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Effects</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($c = 0; $c < count($_SESSION["effectsClusterOfObjEdit"]); $c++) {

                            $resulteke = EffectDB::getByIdMeta($_SESSION["effectsClusterOfObjEdit"][$c]); ?>
                            <tr>
                                <td><?php echo $resulteke['id'] ?></td>
                                <form method="post" action="edit_cluster.php">
                                    <td>
                                        <input class="form-check-input" type="hidden" name="selEffect[]" checked value="<?php echo $resulteke['id'] ?>" id="<?php echo $resulteke['id'] ?>">
                                        <label class="form-check-label" for="<?php echo $resulteke['id'] ?>">
                                            <?php echo $resulteke['name'] ?>
                                        </label>
                                    </td>
                                    <td>
                                        <input type="hidden" value="<?php echo $c ?>" name="deleteEffectListEdit">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="delete_effectFromListEdit"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </td>
                                </form>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
                
                <?php foreach ($clusterMetaData as $m) { ?>

                    <label><?php echo $m ?></label><br>
                    <input class="col-lg-4" value="<?php echo $_SESSION['clusterObjEdit'][$m]; ?>" name="<?php echo $m ?>"><br><br>
                
                <?php } ?>
                
                </div>
                <div class="form-check container" style="overflow: auto; padding-top:25px; width: 35%; float: left;margin-top:10px;">
                <?php if (count($_SESSION["effectsClusterOfObjEdit"]) >= 2) {   ?>
                    <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="edit_The_Cluster" style="margin-top: 8px">Update Cluster</button><br />
                <?php } ?>
                </div>

            <?php } ?>
        
    </form>




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>


    <script>
        $(document).ready(function() {
            load_data();

            function load_data(queryClusterEditCause, columnSearchCauseClusterEdit) {
                $.ajax({
                    url: "fetchCauseEditCluster.php",
                    method: "post",
                    data: {
                        queryClusterEditCause: queryClusterEditCause,
                        columnSearchCauseClusterEdit: columnSearchCauseClusterEdit
                    },
                    success: function(data) {
                        $('#resultClusterEditCause').html(data);
                    }
                });
            }

            $('#search_textClusterEditCause').keyup(function() {
                var search = $(this).val();
                var e = document.getElementById("columnSelectCauseOfClusterEdit");
                var valueCauseColumnClusterEdit = e.options[e.selectedIndex].value;
                if (search != '') {
                    load_data(search, valueCauseColumnClusterEdit);
                } else {
                    load_data();
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            load_data();

            function load_data(queryClusterEditEffect, columnSearchEffectClusterEdit) {
                $.ajax({
                    url: "fetchEffectEditCluster.php",
                    method: "post",
                    data: {
                        queryClusterEditEffect: queryClusterEditEffect,
                        columnSearchEffectClusterEdit: columnSearchEffectClusterEdit
                    },
                    success: function(data) {
                        $('#resultClusterEditEffect').html(data);
                    }
                });
            }

            $('#search_textClusterEffect').keyup(function() {
                var search = $(this).val();
                var e = document.getElementById("columnSelectEffectOfClusterEdit");
                var valueEffectColumnClusterEdit = e.options[e.selectedIndex].value;
                if (search != '') {
                    load_data(search, valueEffectColumnClusterEdit);
                } else {
                    load_data();
                }
            });
        });
    </script>

</body>

</html>