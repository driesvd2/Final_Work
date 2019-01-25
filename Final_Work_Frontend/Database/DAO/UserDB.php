<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 25/01/2019
 * Time: 01:21
 */

include_once "Models/User.php";
include_once "Database/DatabaseFactory.php";

class UserDB
{
    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function Login($username, $password) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM User WHERE username='$username' AND password='$password'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarUser($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        foreach ($resultatenArray as $e){
            if ($e->username == $username && $e->password == $password){
                return $e->userType;
            }
        }
        return 99;
    }

    protected static function converteerRijNaarUser($databaseRij) {
        return new User($databaseRij['userId'], $databaseRij['username'], $databaseRij['password'], $databaseRij['userType']);
    }
}