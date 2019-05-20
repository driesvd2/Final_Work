<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
error_reporting(E_ERROR | E_PARSE);
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



include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/EffectTagDB.php';

include 'Database/Forms/UpdateEffect/server.php';
if ($_SESSION['type'] != 0 || !isset($_SESSION['type'])) {
    header('location: login.php');
}
if ($_SESSION['type'] == 0 && isset($_SESSION['type']) && !isset($_GET['id']) || empty($_GET['id']) || ctype_space($_GET['id']) || EffectDB::getByIdMeta($_GET['id']) == null) {
    header('location: index.php');
}
?>

<html>

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

<body>
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
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
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

    <div class="container" style="width: 50%; float: left">
        <h1>Update Effect</h1>
        <?php $effectMetaColumns = EffectDB::getAllMetaColumnsOfEffect(); ?>
        <?php $effectMetaColumnsGetByid = EffectDB::getByIdMeta($_GET['id']); ?>
        <?php $selectedEffectPropId = EffectDB::getById($_GET['id']); ?>
        <?php $selectedEffectPropName = EffectTagDB::getById($selectedEffectPropId[0]->tag); ?>
        <?php $getAllEffectTags = EffectTagDB::getAll(); ?>
        <div>
            <form method="post" action="edit_Effect.php">
                <input type="hidden" value="<?php echo $effectMetaColumnsGetByid["id"]; ?>" name="id" />
                <label><?php echo "name"; ?></label><br>
                <input class="col-lg-4" value="<?php echo $effectMetaColumnsGetByid["name"]; ?>" name="name">
                <input class="col-lg-4" type="hidden" value="<?php echo $effectMetaColumnsGetByid["status"]; ?>" name="status"><br><br>

                <?php foreach ($effectMetaColumns as $m) { ?>

                    <label><?php echo $m; ?></label><br />
                    <input class="col-lg-4" value="<?php echo $effectMetaColumnsGetByid[$m]; ?>" name="<?php echo $m ?>"><br><br>

                <?php } ?>

                <select name="updateEffectTag">                    
                    <?php foreach ($getAllEffectTags as $g) {
                        if (EffectTagDB::ifLast($g->id)) { ?>
                        <option value="<?php echo $g->id; ?>" <?php if ($selectedEffectPropId[0]->tag == $g->id) {echo 'selected';} ?>><?php echo $g->name; ?></option>
                    <?php }} ?>
                    
                </select>
                
                

                <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="update_effect">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../../../Users/Dries/Downloads/Final_Work_Frontend/Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>

</body>

</html>