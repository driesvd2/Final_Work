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

if ($_SESSION['type'] != 0 && $_SESSION['type'] != 1 || !isset($_SESSION['type'])) {
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['login']);
    unset($_SESSION['type']);
    header("location: index.php");
}

include './Database/Forms/DeleteCause/server.php';
include_once './Database/DAO/CauseTagDB.php';
include_once './Database/DAO/EffectTagDB.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ClusterDB.php';

if (isset($_POST['search']) && isset($_POST['search_selectCauseColumn'])) {
    $searchq = $_POST['search'];
    $selColCause = $_POST['search_selectCauseColumn'];
    $searchq = preg_replace_callback("#[^0-9a-z]#i", "", $searchq);
    
    if($_POST['search_selectCauseColumn'] == 'tag'){
        
        $searchTag = $_POST['search'];
        
        $searchTag = preg_replace_callback("#[^0-9a-z]#i", "", $searchTag);
        
        $querySearchTag = CauseTagDB::getSearchTagID($searchTag);
        
        $resultSearchTagsOfCauseTags = array();

        foreach ($querySearchTag as $q) {
            
            array_push($resultSearchTagsOfCauseTags, CauseDB::getAllWhereTag($q->id));
        }
        
    } else{
        
        $querySearchCause = CauseDB::getSearchCause($searchq, $selColCause);
        
    }
    
}

if (isset($_POST['searchEffect']) && isset($_POST['search_selectEffectColumn'])) {
    $searchquery = $_POST['searchEffect'];
    $selColEffect = $_POST['search_selectEffectColumn'];
    $searchquery = preg_replace_callback("#[^0-9a-z]#i", "", $searchquery);
    
    if($_POST['search_selectEffectColumn'] == 'tag') {
        
        $searchTagEffect = $_POST['searchEffect'];
        
        $searchTagEffect = preg_replace_callback("#[^0-9a-z]#i", "", $searchTagEffect);
        
        $querySearchTagEffect = EffectTagDB::getSearchTagID($searchTagEffect);
        
        $resultSearchTagsOfEffectTags = array();

        foreach ($querySearchTagEffect as $q) {
            
            array_push($resultSearchTagsOfEffectTags, EffectDB::getAllWhereTag($q->id));
        }
        
    } else {
        
        $querySearchEffect = EffectDB::getSearchEffect($searchquery, $selColEffect);
        
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
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 1) { ?>
                            <a class="nav-link" href="webservicePage.php"><?php echo 'Search'; ?></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
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


    <?php $metaColumnsCause = CauseDB::getAllColumnsOfCause(); ?>
    <div class="container" style="width: 50%; float:left;">
    <div class="container">
        <h1>Causes <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                <a href="insert_Cause.php" class="greenIcon"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a>
            <?php } ?></h1>
        <form action="index.php" method="post">
            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
            <div class="wrap">
                <div class="search">
                    <input type="text" class="searchTerm" name="search" placeholder="Filter results...">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <br /><br />
            
            <div class="select">
                <select name="search_selectCauseColumn" style="width:120px;">
                <option value="name">---- Filter ----</option>
                    <?php foreach ($metaColumnsCause as $metaSelect) { ?>
                        <option value="<?php echo $metaSelect; ?>"><?php echo $metaSelect; ?></option>
                    <?php } ?>
                </select>
                
                    <a href="manageCauseTable.php" title="Manage cause metadata" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-cog"></i></a>
               
            </div>
            <?php } ?>
            
            <?php errorHandlingDeleteCause() ?>
           
        </form>
    </div> 
    <div class="container" style="height: 60%; float:left; overflow:auto;">
        <?php if (isset($querySearchCause)) { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Tag</th>
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                            <th>Delete</th>
                            <th>Edit</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($q = 0; $q < count($querySearchCause); $q++) { ?>
                        <tr>
                            <td><?php echo $querySearchCause[$q]->id ?></td>
                            <td><?php echo $querySearchCause[$q]->name ?></td>
                            <td><?php $causeTag = CauseTagDB::getById($querySearchCause[$q]->tag); echo $causeTag[0]->name;?></td>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <form method="post" action="index.php">
                                        <input type="hidden" value="<?php echo $querySearchCause[$q]->id ?>" name="delete_idCause">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" style="background-color: #DA291C;" name="delete_cause"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                            <?php } ?>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <a href="edit_Cause.php?id=<?php echo $querySearchCause[$q]->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        
        
        
        <?php } else if (isset($resultSearchTagsOfCauseTags)) { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Tag</th>
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                            <th>Delete</th>
                            <th>Edit</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($q = 0; $q < count($resultSearchTagsOfCauseTags); $q++) { 
                    
                            foreach ($resultSearchTagsOfCauseTags[$q] as $res) {  ?>
                    
                        <tr>
                            <td><?php echo $res->id ?></td>
                            <td><?php echo $res->name ?></td>
                            <td><?php $causeTag = CauseTagDB::getById($res->tag); echo $causeTag[0]->name;?></td>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <form method="post" action="index.php">
                                        <input type="hidden" value="<?php echo $res->id ?>" name="delete_idCause">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" style="background-color: #DA291C;" name="delete_cause"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                            <?php } ?>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <a href="edit_Cause.php?id=<?php echo $res->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        
        

        <?php } else { ?>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cause</th>
                        <th>Tag</th>
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                            <th>Delete</th>
                            <th>Edit</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $causes = CauseDB::getAll();
                    for ($c = 0; $c < count($causes); $c++) { ?>
                        <tr>
                            <td><?php echo $causes[$c]->id ?></td>
                            <td><?php echo $causes[$c]->name ?></td>
                            <td><?php $causeTag = CauseTagDB::getById($causes[$c]->tag); echo $causeTag[0]->name;?></td>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <form method="post" action="index.php">
                                        <input type="hidden" value="<?php echo $causes[$c]->id ?>" name="delete_idCause">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="delete_cause"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                            <?php } ?>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <a href="edit_Cause.php?id=<?php echo $causes[$c]->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    </div>
    

    <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>

    <?php $metaColumnsEffect = EffectDB::getAllColumnsOfEffect(); ?>
    <div class="container" style="width: 50%; float:right;">
    <div class="container">
        <h1>Effects <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                <a href="insert_effect_admin.php" class="greenIcon"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a>
            <?php } ?></h1>
        <form action="index.php" method="post">
            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
            <div class="wrap">
                <div class="search">
                    <input type="text" class="searchTerm" name="searchEffect" placeholder="Filter results...">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <br /><br />
            
            <div class="select">
                <select name="search_selectEffectColumn" style="width:120px;">
                <option value="name">---- Filter ----</option>
                    <?php foreach ($metaColumnsEffect as $metaSelectEff) { ?>
                        <option value="<?php echo $metaSelectEff; ?>"><?php echo $metaSelectEff; ?></option>
                    <?php } ?>
                </select>
                
                    <a href="manageEffectTable.php" title="Manage effect metadata" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-cog"></i></a>
                
            </div>
            <?php } ?>
            
            <?php errorHandlingDeleteEffect(); ?>

        </form>
    </div> 
    <div class="container" style="height: 60%; float:right; overflow:auto;">
        <?php if (isset($querySearchEffect)) { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Effect</th>
                        <th>Tag</th>
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                            <th>Delete</th>
                            <th>Edit</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($q = 0; $q < count($querySearchEffect); $q++) { ?>
                        <tr>
                            <td><?php echo $querySearchEffect[$q]->id ?></td>
                            <td><?php echo $querySearchEffect[$q]->name ?></td>
                            <td><?php $effectTag = EffectTagDB::getById($querySearchEffect[$q]->tag); echo $effectTag[0]->name;?></td>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <form method="post" action="index.php">
                                        <input type="hidden" value="<?php echo $querySearchEffect[$q]->id ?>" name="delete_idEffect">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="delete_effect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                            <?php } ?>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <a href="edit_Effect.php?id=<?php echo $querySearchEffect[$q]->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php } else if (isset($resultSearchTagsOfEffectTags)) { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Effect</th>
                        <th>Tag</th>
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                            <th>Delete</th>
                            <th>Edit</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($q = 0; $q < count($resultSearchTagsOfEffectTags); $q++) { 
                    
                          foreach ($resultSearchTagsOfEffectTags[$q] as $res) { ?>
                        <tr>
                            <td><?php echo $res->id ?></td>
                            <td><?php echo $res->name ?></td>
                            <td><?php $effectTag = EffectTagDB::getById($res->tag); echo $effectTag[0]->name;?></td>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <form method="post" action="index.php">
                                        <input type="hidden" value="<?php echo $res->id ?>" name="delete_idEffect">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="delete_effect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                            <?php } ?>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <a href="edit_Effect.php?id=<?php echo $res->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        
        
        <?php } else { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Effect</th>
                        <th>Tag</th>
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                            <th>Delete</th>
                            <th>Edit</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $effects = EffectDB::getAllWhereStatusIsOneAndTwo();
                    for ($e = 0; $e < count($effects); $e++) { ?>
                        <tr>
                            <td><?php echo $effects[$e]->id ?></td>
                            <td><?php echo $effects[$e]->name ?></td>
                            <td><?php $effectTag = EffectTagDB::getById($effects[$e]->tag); echo $effectTag[0]->name;?></td>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <form method="post" action="index.php">
                                        <input type="hidden" value="<?php echo $effects[$e]->id ?>" name="delete_idEffect">
                                        <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="delete_effect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                    </form>
                                </td>
                            <?php } ?>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <a href="edit_Effect.php?id=<?php echo $effects[$e]->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../../../Users/Dries/Downloads/Final_Work_Frontend/Bootstrap/js/bootstrap.min.js"></script>
    <script src="Bootstrap/jquery-3-3-1.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>

</body>

</html>