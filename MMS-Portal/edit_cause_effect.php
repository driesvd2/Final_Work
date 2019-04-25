<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);

include './Database/Forms/UpdateCauseEffect/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';

session_start();



if ($_SESSION['type'] != 0 || !isset($_SESSION['type'])) {
    header('location: login.php');
}
if (!isset($_GET['id']) || CauseEffectDB::getByIdMeta($_GET['id']) == null) {
    header('location: relations.php');
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

if (isset($_SESSION["insertCauseFromEditCluster"])) {

    unset($_SESSION["insertCauseFromEditCluster"]);
}

if (isset($_SESSION['causeEffectObjEdit'])) {

    unset($_SESSION['causeEffectObjEdit']);
}

if (isset($_GET['id'])) {

    $_SESSION['causeEffectObjEdit'] = CauseEffectDB::getByIdMeta($_GET['id']);

    $_SESSION['causeObjEdit'] = CauseDB::getByIdMeta($_SESSION['causeEffectObjEdit']['cause']);

    $_SESSION['effectObjEdit'] = EffectDB::getByIdMeta($_SESSION['causeEffectObjEdit']['effect']);
}

if (isset($_POST['cause']) && !isset($_POST['effect'])) {

    if (!empty(CauseDB::getById($_POST['cause']))) {

        $_SESSION['causeObjEdit'] = CauseDB::getByIdMeta($_POST['cause']);
    }
}

if (isset($_POST['effect']) && !isset($_POST['cause'])) {

    if (!empty(EffectDB::getById($_POST['effect']))) {

        $_SESSION['effectObjEdit'] = EffectDB::getByIdMeta($_POST['effect']);
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
    <link rel="stylesheet" href="./CSS/custom.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
        <h1>Update Cause - Effect</h1>
        <?php $metaColumnsCause = CauseDB::getAllColumnsOfCause(); ?>
        <?php $metaColumnsEffect = EffectDB::getAllColumnsOfEffect(); ?>
        <form method="post" action="edit_cause_effect.php">
            <h2>Causes <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                    <a href="insert_Cause.php?clickedOnCauseEffectEdit=editCauseEffect&id=<?php echo $_SESSION['causeEffectObjEdit']['id'] ?>" class="greenIcon"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a>
                
                <?php } ?></h2>
            <div class="wrap" style="height: 25px">
                <div class="search">
                    <div class="input-group">
                        <input type="text" class="searchTermAjax" name="search_textEditCause" id="search_textEditCause" placeholder="Filter Causes" class="form-control" />
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="select">
                <label></label>
                <select id="columnSelectCauseOfCauseEffectEdit" name="search_selectCauseColumnCauseEffectEdit" style="width:120px;">
                    <option value="name">---- Filter ----</option>
                    <?php foreach ($metaColumnsCause as $metaSelect) { ?>
                        <option value="<?php echo $metaSelect; ?>"><?php echo $metaSelect; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div id="resultCauseEffectEditCause" class="container" style="float: left; overflow: auto; height: 15%; margin-top: 8px; margin-bottom: 8px"></div>

            <h2>Effects</h2>

            <div class="wrap" style="height: 25px">
                <div class="search">
                    <div class="input-group">
                        <input type="text" class="searchTermAjax" name="search_textEditEffect" id="search_textEditEffect" placeholder="Filter Effects" class="form-control" />
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="select">
                <label></label>
                <select id="columnSelectEffectOfCauseEffectEdit" name="search_selectEffectColumnCauseEffectEdit" style="width:120px;">
                    <option value="name">-- Filter --</option>
                    <?php foreach ($metaColumnsEffect as $metaSelect) { ?>
                        <option value="<?php echo $metaSelect; ?>"><?php echo $metaSelect; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div id="resultCauseEffectEditEffect" class="container" style="float: left; overflow: auto; height: 15%; margin-top: 8px; margin-bottom: 8px"></div>

        </form>

    </div>

    <?php $causeEffectMetaData = CauseEffectDB::getAllMetaColumnsOfCauseEffect(); ?>
    <form method="post" action="edit_cause_effect.php">

        <div class="form-check container" style="overflow: auto; height: 80%; width: 50%; float: left;">

            <h2>Cause</h2>

            <input class="form-check-input" type="hidden" name="id" value="<?php echo $_SESSION['causeEffectObjEdit']['id']; ?>" id="<?php echo $_SESSION['causeEffectObjEdit']['id'] ?>">

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $_SESSION['causeObjEdit']['id']; ?></td>
                        <td>
                            <input class="form-check-input" type="hidden" name="cause" checked value="<?php echo $_SESSION['causeObjEdit']['id']; ?>" id="<?php echo $_SESSION['causeObjEdit']['id'] ?>">
                            <label class="form-check-label" for="<?php echo $_SESSION['causeObjEdit']['id']; ?>">
                                <?php echo $_SESSION['causeObjEdit']['name']; ?>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2>Effect</h2>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Effect</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $_SESSION['effectObjEdit']['id'] ?></td>
                        <td>
                            <input class="form-check-input" type="hidden" name="effect" checked value="<?php echo $_SESSION['effectObjEdit']['id']; ?>" id="<?php echo $_SESSION['effectObjEdit']['id'] ?>">
                            <label class="form-check-label" for="<?php echo $_SESSION['effectObjEdit']['id']; ?>">
                                <?php echo $_SESSION['effectObjEdit']['name']; ?>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php foreach ($causeEffectMetaData as $m) { ?>

                <label><?php echo $m ?></label><br>
                <input class="col-lg-4" value="<?php echo $_SESSION['causeEffectObjEdit'][$m]; ?>" name="<?php echo $m ?>"><br><br>

            <?php } ?>

            <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="update_causeEffect">Update Cause-Effect</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>


    <script>
        $(document).ready(function() {
            load_data();

            function load_data(queryCauseEffectEditCause, columnSearchCauseCauseEffectEdit) {
                $.ajax({
                    url: "fetchCauseEditCauseEffect.php",
                    method: "post",
                    data: {
                        queryCauseEffectEditCause: queryCauseEffectEditCause,
                        columnSearchCauseCauseEffectEdit: columnSearchCauseCauseEffectEdit
                    },
                    success: function(data) {
                        $('#resultCauseEffectEditCause').html(data);
                    }
                });
            }

            $('#search_textEditCause').keyup(function() {
                var search = $(this).val();
                var e = document.getElementById("columnSelectCauseOfCauseEffectEdit");
                var valueCauseColumnCauseEffectEdit = e.options[e.selectedIndex].value;
                if (search != '') {
                    load_data(search, valueCauseColumnCauseEffectEdit);
                } else {
                    load_data();
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            load_data();

            function load_data(queryCauseEffectEditEffect, columnSearchEffectCauseEffectEdit) {
                $.ajax({
                    url: "fetchEffectEditCauseEffect.php",
                    method: "post",
                    data: {
                        queryCauseEffectEditEffect: queryCauseEffectEditEffect,
                        columnSearchEffectCauseEffectEdit: columnSearchEffectCauseEffectEdit
                    },
                    success: function(data) {
                        $('#resultCauseEffectEditEffect').html(data);
                    }
                });
            }

            $('#search_textEditEffect').keyup(function() {
                var search = $(this).val();
                var e = document.getElementById("columnSelectEffectOfCauseEffectEdit");
                var valueEffectColumnCauseEffectEdit = e.options[e.selectedIndex].value;
                if (search != '') {
                    load_data(search, valueEffectColumnCauseEffectEdit);
                } else {
                    load_data();
                }
            });
        });
    </script>
</body>

</html>