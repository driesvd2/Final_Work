<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
error_reporting(E_ERROR | E_PARSE);
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

if (isset($_SESSION["insertCauseFromEditCluster"])) {

    unset($_SESSION["insertCauseFromEditCluster"]);
}

include './Database/Forms/InsertEffectAdmin/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/EffectTagDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';

if ($_SESSION['type'] != 0 || !isset($_SESSION['type'])) {
    header('location: login.php');
}

if(isset($_GET['id'])){
    $effect = EffectDB::getById($_GET['id']);
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
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home
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
    
    <?php 
        if (isset($_POST['tag'])) {
            if (EffectTagDB::ifLast($_POST['tag'])) {
                unset($tags);
                $effects = EffectDB::getAllWhereTag($_POST['tag']);
                $tag = EffectTagDB::getById($_POST['tag']);
            }else{
                $tag = EffectTagDB::getById($_POST['tag']);
                $tags = EffectTagDB::getAllWhereParent($tag[0]->id);
                $tag = null;
            }
        }else{
            $tags = EffectTagDB::getAllFirst();
        }
    ?>

    <div class="container" style="width: 50%; float: left;">
        <h1>Insert Effect</h1>
        <p>Check if the Effect is not already listed on the right.</p>
        <form method="post" action="insert_effect_admin.php">
            <div class="form-group">
                <label for="Cause">Effect: </label>
                <input type="hidden" name="insertTag" value="<?php echo $tag[0]->id ?>">
                <input type="hidden" name="id" <?php if (isset($effect)) {echo 'value="'.$effect[0]->id.'"';}else if (isset($_POST['id'])) {echo 'value="'.$_POST['id'].'"';} ?>>
                <input type="text" class="form-control" id="Effect" name="name" <?php if (isset($effect)) {echo 'value="'.$effect[0]->name.'"';}else if (isset($_POST['getEffect'])) {echo 'value="'.$_POST['getEffect'].'"';} ?> placeholder="Enter Effect..." required>
            </div>
            <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="insert_effect_admin">Insert</button>
        </form>
        <h1>Categories <a href="insert_EffectTag.php" class="greenIcon"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a></h1>
        <div class="container" style="width: 100%; height:35%; float: left;overflow:auto">
        <form method="post" action="insert_effect_admin.php">
        <input type="hidden" name="getEffect" <?php if (isset($effect)) {echo 'value="'.$effect[0]->name.'"';}else if (isset($_POST['getEffect'])) {echo 'value="'.$_POST['getEffect'].'"';} ?> >
        <input type="hidden" name="id" <?php if (isset($effect)) {echo 'value="'.$effect[0]->id.'"';}else if (isset($_POST['id'])) {echo 'value="'.$_POST['id'].'"';} ?>>   
            <?php if(isset($tags)){ ?>
                <div class="form-check">
            <?php foreach($tags as $t){ ?>
                <input class="form-check-input" onchange="this.form.submit()" type="radio" name="tag" value="<?php echo $t->id ?>" id="<?php echo $t->id ?>">
                <label class="form-check-label" for="<?php echo $t->id ?>">
                    <?php echo $t->name ?>
                </label><br/>
                <?php }}else{?>
                <p><?php echo $tag[0]->name ?></p>
                <?php }?>
                </div>
        </form>
        </div>
    </div>

    <div class="container" style="width: 50%;float: left;">
        <div class="container">
        <?php 
        if(!isset($effects)){ 
            echo '<h1>All Effects</h1>';
            $effects = EffectDB::getAllWhereStatusIsOneAndTwo();
        }else{
            echo '<h1>Effects in '.$tag[0]->name.'</h1>';
        } ?>
        </div>
        <div class="container" style="float: left; height: 60%;overflow:auto">
            <table class="table table-bordered table-hover" >
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Effect</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($effects as $c){  ?>
                    <tr>
                        <td><?php echo $c->id ?></td>
                        <td><?php echo $c->name ?></td>
                    </tr>
                <?php } ?>
                
            </tbody>
        </table> 
        </div>               
     </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../../../Users/Dries/Downloads/Final_Work_Frontend/Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>

</body>

</html>