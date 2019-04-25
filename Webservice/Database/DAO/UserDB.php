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
    private static function getVerbinding()
    {
        return DatabaseFactory::getDatabase();
    }

    public static function getAllUsers()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM User");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarUser($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }



    public static function Login($username, $password)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM User WHERE username='$username' AND password='$password'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarUser($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        foreach ($resultatenArray as $e) {
            if ($e->username == $username && $e->password == $password) {
                return $e->type;
            }
        }
        return 99;
    }

    public static function getById($id)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM User WHERE id=" . $id);
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarUser($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getSearchUser($searchq, $column)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from User where '$column' LIKE '%$searchq%'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarUser($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


    public static function insertUser($user)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO User(username , password , type) VALUES ('?','?','?')", array($user->username, $user->password, $user->type));
    }


    public static function insertNewUser($username, $password, $usertype)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO User(id,username, password, type) VALUES (null, '$username','$password',$usertype)");
    }


    public static function deleteByIdQueue($id)
    {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM User WHERE id=" . $id);
    }


    public static function updateUser($username, $password, $adminornot, $userid)
    {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE User SET username='$username', password='$password', type=$adminornot WHERE id=$userid");
    }

    /*public static function update($causename,$id) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cause SET name='$causename' WHERE id= $id");
   }*/

    public static function converteerRijNaarUser($databaseRij)
    {
        return new User(
            $databaseRij['id'],
            $databaseRij['username'],
            $databaseRij['password'],
            $databaseRij['type']
        );
    }
}
