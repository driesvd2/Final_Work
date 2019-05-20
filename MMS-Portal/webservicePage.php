<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
error_reporting(E_ERROR | E_PARSE);
if (isset($_SESSION["deIdVanStatusPageCauseEffect"])) {

    unset($_SESSION["deIdVanStatusPageCauseEffect"]);
}

// if (isset($_SESSION['causeOnChangeName']) || isset($_SESSION['effectOnChangeName'])) {

//     unset($_SESSION['causeOnChangeName']);
//     unset($_SESSION['effectOnChangeName']);
// }

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

include './Database/Forms/WebserviceForm/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';

if ($_SESSION['type'] != 1 || !isset($_SESSION['type'])) {
    header('location: login.php');
}
if ($_SESSION['type'] == 0 && isset($_SESSION['type'])) {
    header('location: index.php');
}

if (isset($_POST["deleteEffectList"]) && isset($_POST["delete_effectFromList"])) {


    unset($_SESSION['effectOnChangeNameWeb'][$_POST["deleteEffectList"]]);


    $_SESSION['effectOnChangeNameWeb'] = array_values($_SESSION['effectOnChangeNameWeb']);
}
?>

<html style="height: 100%;overflow:auto">

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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 1) { ?>
                            <a class="nav-link" href="webservicePage.php"><?php echo 'Search'; ?><span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item active">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="manage_status_effect.php"><?php echo 'Status Effect'; ?></a>
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

    <div class="container" style="margin-left:1%;width: 48%; float: left; height: 80%; ">
        <?php $metaColumnsEffect = EffectDB::getAllColumnsOfEffect(); ?>
        <form method="post" action="webservicePage.php" onchange="this.form.submit()">
            <h1>Effects</h1>
            <div class="wrap" style="height: 25px">
                <div class="search">
                    <div class="input-group">
                        <input type="text" class="searchTermAjax" name="search_textWebservice" id="search_textWebservice" placeholder="Filter Effects" class="form-control" />
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="select">
                <label></label>
                <select id="columnSelectEffectWebservice" name="search_selectEffectWebserviceColumn" style="width:120px;">
                    <option value="name">---- Filter ----</option>
                    <?php foreach ($metaColumnsEffect as $metaSelectEff) { ?>
                        <option value="<?php echo $metaSelectEff; ?>"><?php echo $metaSelectEff; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div id="resultWebserviceSearch" class="container" style="float: left; overflow: auto; margin-top: 8px; margin-bottom: 8px;height: 70%;"></div>
        </form>
    </div>

    
        <form method="post" action="webservicePage.php">

            <?php

            if (isset($_POST['selecEffect']) && !isset($_SESSION["effectOnChangeNameWeb"])) {

                $effectsInitSession = EffectDB::getById($_POST['selecEffect']);

                $_SESSION["effectOnChangeNameWeb"] = array();

                array_push($_SESSION["effectOnChangeNameWeb"], $effectsInitSession[0]->id);
            } else if (isset($_POST['selecEffect']) && isset($_SESSION["effectOnChangeNameWeb"])) {


                $sessietje = array();

                $caughtEffect = EffectDB::getById($_POST['selecEffect']);

                if (is_array($sessietje)) {
                    if (in_array($caughtEffect[0]->id, $_SESSION["effectOnChangeNameWeb"])) {

                        echo "<script type='text/javascript'>alert('Effect already in the list!');</script>";
                    } else {

                        array_push($_SESSION["effectOnChangeNameWeb"], $caughtEffect[0]->id);
                    }
                }
            } ?>

            <?php if (!isset($_SESSION["effectOnChangeNameWeb"]) && !isset($_SESSION["catchedCause"])) { ?>
                <div class="form-check container" style="overflow: auto; height: 70%; width: 50%; float: left;">
                    <h1>Selected effects</h1>
                    <p>No effects selected</p>
                </div>
            <?php } else if (isset($_SESSION["effectOnChangeNameWeb"]) && !isset($_SESSION["catchedCause"])) { ?>

                <h1>Selected effects</h1>
                <div class="form-check container" style="overflow: auto; height: 68%; width: 50%; float: left;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Effects</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($c = 0; $c < count($_SESSION["effectOnChangeNameWeb"]); $c++) {

                                $resulteke = EffectDB::getById($_SESSION["effectOnChangeNameWeb"][$c]); ?>
                                <tr>
                                    <td><?php echo $resulteke[0]->id; ?></td>
                                    <form method="post" action="webservicePage.php">
                                        <td>
                                            <input class="form-check-input" type="hidden" name="selectedEffectsSessionWeb[]" checked value="<?php echo $resulteke[0]->id ?>" id="<?php echo $resulteke[0]->id ?>">
                                            <label class="form-check-label" for="<?php echo $resulteke[0]->id ?>">
                                                <?php echo $resulteke[0]->name ?>
                                            </label>
                                        </td>
                                        <td>
                                            <input type="hidden" value="<?php echo $c ?>" name="deleteEffectList">
                                            <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="delete_effectFromList"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                        </td>
                                    </form>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    </div>
                    <div class="form-check container" style="overflow: auto; height: 12%; width: 35%; float: left;margin-top:10px;">    
                    <?php if (count($_SESSION["effectOnChangeNameWeb"]) >= 2) {   ?>
                        <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="sendForWebservice" style="margin-top: 8px">Insert</button><br />
                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="unsetSessionsWebservice" style="margin-top: 8px">Clear all</button>
                    <?php } ?>
                    </div>
                


            <?php } else if (isset($_SESSION["catchedCause"]) || isset($_SESSION["catchedCauseEffects"])) { ?>

                <?php if ($_SESSION["catchedCause"] == null && $_SESSION["catchedCauseEffects"] == null) { ?>
                    <div class="form-check container" style="overflow: auto; float: left">
                        <p>Try again, no causes catched...</p>
                        <button type="submit" class="btn btn-primary" style="background-color: #223A50;" name="new_search_webservice">New search</button>
                    </div>
                <?php } else if ($_SESSION["catchedCause"] != null && $_SESSION["catchedCauseEffects"] == null) { ?>
                    <div class="form-check container" style="overflow: auto; height: 75%; width: 50%; float: left;">
                        <h1>Cluster</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Catched causes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["catchedCause"] as $deGecatcheteCause) {    ?>
                                    <tr>
                                        <td>
                                            <?php echo $deGecatcheteCause[0]->id ?>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?php echo $deGecatcheteCause[0]->id ?>">
                                                <?php echo $deGecatcheteCause[0]->name ?>
                                            </label>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <button type="submit" class="btn btn-primary" style="background-color: #223A50; margin-top:15px; margin-left:20px;" name="new_search_webservice">New search</button>
                <?php } else if ($_SESSION["catchedCause"] == null && $_SESSION["catchedCauseEffects"] != null) { ?>
                    <div class="form-check container" style="overflow: auto; height: 75%; width: 50%; float: left;">
                        <h1>Cause-Effect</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Effect</th>
                                    <th>Catched causes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["catchedCauseEffects"] as $deGecatcheteCause) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php $effect = EffectDB::getById($deGecatcheteCause->effect);
                                                echo $effect[0]->name; ?>
                                            </td>
                                            <td>
                                                <?php $cause = CauseDB::getById($deGecatcheteCause->cause);
                                                echo $cause[0]->name; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                        <?php if($_SESSION['more'] < sizeof($_SESSION["effectOnChangeNameWeb"]) && sizeof($_SESSION["effectOnChangeNameWeb"]) > 20){?>
                        <button type="submit" class="btn btn-primary" style="background-color: #223A50;" name="more">Search for More</button>
                        <?php } ?>
                    </div>
                <button type="submit" class="btn btn-primary" style="background-color: #223A50; margin-top:15px; margin-left:20px;" name="new_search_webservice">New search</button>
                <?php } else if ($_SESSION["catchedCause"] != null && $_SESSION["catchedCauseEffects"] != null) { ?>
                <div class="form-check container" style="overflow: auto; height: 75%; width: 50%; float: left;">
                        <h1>Cluster</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Catched causes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["catchedCause"] as $deGecatcheteCause) {    ?>
                                    <tr>
                                        <td>
                                            <?php echo $deGecatcheteCause[0]->id ?>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?php echo $deGecatcheteCause[0]->id ?>">
                                                <?php echo $deGecatcheteCause[0]->name ?>
                                            </label>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <br>
                        <h1>Cause-Effect</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Effect</th>
                                    <th>Catched causes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["catchedCauseEffects"] as $deGecatcheteCause) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php $effect = EffectDB::getById($deGecatcheteCause->effect);
                                                echo $effect[0]->name; ?>
                                            </td>
                                            <td>
                                                <?php $cause = CauseDB::getById($deGecatcheteCause->cause);
                                                echo $cause[0]->name; ?>
                                            </td>
                                        </tr>
                                    <?php }?>
                            </tbody>
                        </table>
                        <?php if(isset($_SERVER['more']) && $_SESSION['more'] < sizeof($_SESSION["effectOnChangeNameWeb"]) && sizeof($_SESSION["effectOnChangeNameWeb"]) > 20){?>
                        <button type="submit" class="btn btn-primary" style="background-color: #223A50;" name="more">Search for More</button>
                        <?php } ?>
                    </div>
                <button type="submit" class="btn btn-primary" style="background-color: #223A50; margin-top:15px; margin-left:20px;" name="new_search_webservice">New search</button>
                <?php } ?>
            <?php  } ?>
        </form>
    

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>

    <script>
        $(document).ready(function() {
            load_data();

            function load_data(queryWebservice, columnSearchEffectWebservice) {
                $.ajax({
                    url: "fetchWebservice.php",
                    method: "post",
                    data: {
                        queryWebservice: queryWebservice,
                        columnSearchEffectWebservice: columnSearchEffectWebservice
                    },
                    success: function(data) {
                        $('#resultWebserviceSearch').html(data);
                    }
                });
            }

            $('#search_textWebservice').keyup(function() {
                var search = $(this).val();
                var e = document.getElementById("columnSelectEffectWebservice");
                var valueColumnEffectWebservice = e.options[e.selectedIndex].value;
                if (search != '') {
                    load_data(search, valueColumnEffectWebservice);
                } else {
                    load_data();
                }
            });
        });
    </script>

</body>

</html>