<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 25/01/2019
 * Time: 13:05
 */

session_start();

include 'Database/ApproveQueue/server.php';
include_once './Database/DAO/CauseEffectDB.php';
include_once './Database/DAO/CauseDB.php';
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/ErrorDB.php';
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Final Work">
    <meta name="author" content="Dries Van Dievoort & Stefanos Stoikos">
    <title>
        Final Work - MMS DB Acces
    </title>
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                            <a class="nav-link" href="admin.php"><?php echo 'Admin'; ?><span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login']) && $_SESSION['userType'] == 1){ ?>
                            <a class="nav-link" href="insert.php"><?php echo 'Insert'; ?></a>
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

    <div class="container" style="width: 95%">
        <h1>Effects to Approve</h1>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Effect</th>
                <th>Approve</th>
                <th>Decline</th>
            </tr>
            </thead>
            <tbody>
            <?php $effects = EffectDB::getAllQueue();
            for ($e = 0; $e < count($effects); $e++){?>
                <tr>
                    <td><?php echo $e + 1 ?></td>
                    <td><?php echo $effects[$e]->EffectName ?></td>
                    <td>
                        <form method="post" action="admin.php">
                            <input type="hidden" value="<?php echo $effects[$e]->EffectName?>" name="aprove_EffectName">
                            <input type="hidden" value="<?php echo $effects[$e]->idEffect?>" name="aprove_EffectId">
                            <button type="submit" class="btn btn-success" name="approve_effect">Approve</button>

                    </td>
                    <td>
                        <form method="post" action="admin.php">
                        <input type="hidden" value="<?php echo $effects[$e]->idEffect?>" name="decline_EffectId">
                        <button type="submit" class="btn btn-danger" name="decline_effect">Decline</button>
                        </form>
                    </td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
