<?php

include_once './Database/DAO/UserDB.php';

//Delete user
if (isset($_POST['delete_user']) && isset($_POST['delete_userid'])) {
    UserDB::deleteByIdQueue($_POST['delete_userid']);
}

?>