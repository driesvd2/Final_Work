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

include './Database/Forms/DeleteCause/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ErrorDB.php';
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

<body style="height: 100%;">
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
                            <a class="nav-link" href="relations.php"><?php echo 'Relations'; ?></a>
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
    
    
    
                                

    <div class="container" style="width: 50%; float: left;overflow: auto; height: 90%;">
            <h1>Causes <?php  if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){   ?>
            <a href="insert_Cause.php"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a>
            <?php } ?></h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cause</th>
                        <?php  if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){   ?>
                        <th>Delete</th>
                        <th>Update</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
            <?php $causes = CauseDB::getAll();
            for($c = 0; $c < count($causes); $c++){ ?>
                <tr>
                    <td><?php echo $c+1 ?></td>
                    <td><?php echo $causes[$c]->CauseName ?></td>
                    <?php  if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){   ?>
                    <td>
                        <form method="post" action="index.php">
                        <input type="hidden" value="<?php echo $causes[$c]->idCause?>" name="delete_idCause">
                        <button type="submit" class="btn btn-danger" name="delete_cause"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                        </form>
                    </td>
                    <?php } ?>
                    <?php  if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){   ?>
                    <td>
                        <a href="edit_Cause.php?idCause=<?php echo $causes[$c]->idCause; ?>" class="btn btn-primary"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                    </td>
                    <?php } ?>
                </tr>
            <?php } ?>
                </tbody>
            </table>
    </div>
    <div class="container" style="width: 50%; float: left;overflow: auto; height: 90%;">
        <h1>Effects <?php  if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){   ?>
        <a href="insert_effect_admin.php"><i class="fa fa-plus-square" style="font-size: 28px;"></i></a>
        <?php } ?></h1>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Effect</th>
                <?php  if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){   ?>
                <th>Delete</th>
                <th>Update</th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php $effects = EffectDB::getAll();
            for ($e = 0; $e < count($effects); $e++){ ?>
                <tr>
                    <td><?php echo $e + 1 ?></td>
                    <td><?php echo $effects[$e]->EffectName ?></td>
                    <?php  if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){   ?>
                    <td>
                        <form method="post" action="index.php">
                        <input type="hidden" value="<?php echo $effects[$e]->idEffect?>" name="delete_idEffect">
                        <button type="submit" class="btn btn-danger" name="delete_effect"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                        </form>
                    </td>
                    <?php } ?>
                    <?php  if(isset($_SESSION['login']) && $_SESSION['userType'] == 0){   ?>
                    <td>
                        <a href="edit_Effect.php?idEffect=<?php echo $effects[$e]->idEffect; ?>" class="btn btn-primary"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                    </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    
    
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="../../../Users/Dries/Downloads/Final_Work_Frontend/Bootstrap/js/bootstrap.min.js"></script>
    
</body>

</html>
