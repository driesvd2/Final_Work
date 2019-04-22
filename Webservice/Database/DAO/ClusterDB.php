<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 20/02/2019
 * Time: 21:33
 */

include_once "Models/Cause.php";
include_once "Models/Effect.php";
include_once "Models/Cluster.php";
include_once "Database/DatabaseFactory.php";

class ClusterDB
{
    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getAll() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cluster");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCluster($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getById($id) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cluster WHERE id=" .$id);
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCluster($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function insert($causeid, $array) {
        $string = self::arrayToClusterEffects($array);
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Cluster(id, cause,effects) VALUES (null ,'$causeid','$string')");
    }


    public static function arrayToClusterEffects($array){
        sort($array);
        $string = "|";
        foreach ($array as $a){
            $string .= "". $a . "|";
        }
        return $string;
    }

    public static function ifExists($causeid, $array){
        $string = self::arrayToClusterEffects($array);
        $mysqli = new mysqli("dt5.ehb.be", "1819FW_DRIESD_STEFANOSS", "DzwWqw", "1819FW_DRIESD_STEFANOSS");
        $result = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cluster WHERE cause=".$causeid." AND effects= '$string'");
        if($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
        $mysqli->close();
    }

    public static function getCausesForAPI($array){
        $causes = array();
        $counter = 0;
        $query = "SELECT * FROM Cluster WHERE 1!=1 OR (";
        foreach ($array as $a){
            $query = "SELECT * FROM Cluster WHERE 1!=1 OR (";
            for ($i = 0;$i < count($a); $i++){
                $counter++;
                $query .= "effects like '%$a[$i]%' AND ";
            }
            $query .= " 1=1)";
            $mysqli = new mysqli("dt5.ehb.be", "1819FW_DRIESD_STEFANOSS", "DzwWqw", "1819FW_DRIESD_STEFANOSS");
            $resultaat = $mysqli->query($query);
            $resultatenArray = array();
            for ($index = 0; $index < $resultaat->num_rows; $index++) {
                $databaseRij = $resultaat->fetch_array();
                $nieuw = self::converteerRijNaarCluster($databaseRij);
                $resultatenArray[$index] = $nieuw;
            }
            for($i = 0;$i < $counter; $i++){
                array_push($causes, $resultatenArray);
            }
            $counter = 0;
        }
        return $causes;
    }

    public static function updateClusterCause($id,$causeid) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cluster SET cause=".$causeid." WHERE id=".$id);
    }

    public static function updateClusterEffect($id,$array) {
        $string = self::arrayToClusterEffects($array);
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cluster SET effects=".$string." WHERE id=".$id);
    }

    public static function deleteById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Cluster WHERE id=".$id);
    }


    public static function translateStringToEffects($string){
        preg_match_all('!\d+!', $string, $matches);
        return $matches[0];
    }


    protected static function converteerRijNaarCluster($databaseRij) {
        return new Cluster($databaseRij['id'], $databaseRij['cause'], $databaseRij['effects']);
    }

    protected static function converteerRijNaarEffect($databaseRij) {
        return new Effect($databaseRij['id'], $databaseRij['name'], $databaseRij['status'], $databaseRij['Error_idError']);
    }

    protected static function converteerRijNaarCause($databaseRij) {
        return new Cause($databaseRij['id'], $databaseRij['name']);
    }
}