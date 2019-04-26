<?php
ini_set('session.cache_limiter', 'public');
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

include './Database/Forms/InsertUser/insertuser.php';
include './Database/Forms/DeleteUser/server.php';
include_once './Database/DAO/UserDB.php';



if ($_SESSION['type'] != 0 || !isset($_SESSION['type'])) {
    header('location: login.php');
}


if (isset($_POST['search']) && isset($_POST['user_column'])) {

    $searchq = $_POST['search'];

    $searchq = preg_replace_callback("#[^0-9a-z]#i", function ($found) {
        return strtolower($found[1]);
    }, $searchq);

    $querysearchuser = UserDB::getSearchUser($searchq, $_POST['user_column']);
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home
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
                    <li class="nav-item active">
                        <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) { ?>
                            <a class="nav-link" href="manageUser.php"><span class="sr-only">(current)</span><?php echo 'User Management & Webservice'; ?></a>
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
        <h1>Insert User</h1>
        <p>Check if the User is not already listed on the right.</p>
        <form method="post" action="manageUser.php">
            <div class="form-group">
                <label>Username: </label>
                <input type="text" class="form-control" id="Username" name="Username" placeholder="Enter User..." required>
                <label>Password: </label>
                <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter password..." required>
            </div>
            <button type="submit" class="btn btn-success" style="background-color: #0b6623;" name="insert_user">Insert</button>
        </form>
    </div>



 
        <div class="container" style="width: 50%; float:right;">
        <div class="container">    
        <h1>Users</h1>
        <form action="manageUser.php" method="post">
            <div class="wrap">
                <div class="search">
                    <input type="text" class="searchTerm" name="search" placeholder="Filter results...">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <br /><br />
            <?php $getMetaUser = UserDB::getAllColumnsOfUser(); ?>
            <div class="select">
                <select name="user_column" style="width:120px;">
                    <option value="username">---- Filter ----</option>
                    <?php foreach ($getMetaUser as $metaSelect) { ?>
                        <option value="<?php echo $metaSelect; ?>"><?php echo $metaSelect; ?></option>
                    <?php } ?>
                </select>
            </div>
        </form>
        </div>
        <div class="container" style="height: 60%; float:right; overflow:auto;">
        <?php if (isset($querysearchuser)) { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($e = 0; $e < count($querysearchuser); $e++) { ?>
                        <tr>
                            <td><?php echo $querysearchuser[$e]->id ?></td>
                            <td><?php echo $querysearchuser[$e]->username ?></td>
                            <td>
                                <form method="post" action="manageUser.php">
                                    <input type="hidden" value="<?php echo $querysearchuser[$e]->id ?>" name="delete_userid">
                                    <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="delete_user"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                </form>
                            </td>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <a href="edit_User.php?id=<?php echo $querysearchuser[$e]->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $users = UserDB::getAllUsers();
                    for ($e = 0; $e < count($users); $e++) { ?>
                        <tr>
                            <td><?php echo $users[$e]->id ?></td>
                            <td><?php echo $users[$e]->username ?></td>
                            <td>
                                <form method="post" action="manageUser.php">
                                    <input type="hidden" value="<?php echo $users[$e]->id ?>" name="delete_userid">
                                    <button type="submit" class="btn btn-danger" style="background-color: #DA291C;" name="delete_user"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                </form>
                            </td>
                            <?php if (isset($_SESSION['login']) && $_SESSION['type'] == 0) {   ?>
                                <td>
                                    <a href="edit_User.php?id=<?php echo $users[$e]->id; ?>" class="btn btn-primary" style="background-color: #223A50;"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
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