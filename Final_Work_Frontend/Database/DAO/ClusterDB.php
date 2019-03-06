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
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cluster WHERE idCluster=" .$id);
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCluster($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchCluster($searchq) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Cluster where Cause_idCause LIKE '%$searchq%'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCluster($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function insert($causeid, $array) {
        $string = self::arrayToClusterEffects($array);
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Cluster(idCluster, Cause_idCause,Cluster_Effects) VALUES (null ,'$causeid','$string')");
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
        $result = $mysqli->query("SELECT * FROM Cluster WHERE Cause_idCause=".$causeid." AND Cluster_Effects= '$string'");
        if($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
        $mysqli->close();
    }

    public static function updateClusterCause($idCluster,$causeid) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cluster SET Cause_idCause=".$causeid." WHERE idCluster=".$idCluster);
    }

    public static function updateClusterEffect($idCluster,$array) {
        $string = self::arrayToClusterEffects($array);
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cluster SET Cluster_Effects=".$string." WHERE idCluster=".$idCluster);
    }

    public static function deleteById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Cluster WHERE idCluster=".$id);
    }


    public static function translateStringToEffects($string){
        preg_match_all('!\d+!', $string, $matches);
        return $matches[0];
    }


    protected static function converteerRijNaarCluster($databaseRij) {
        return new Cluster($databaseRij['idCluster'], $databaseRij['Cause_idCause'], $databaseRij['Cluster_Effects']);
    }

    protected static function converteerRijNaarEffect($databaseRij) {
        return new Effect($databaseRij['idEffect'], $databaseRij['EffectName'], $databaseRij['EffectStatus'], $databaseRij['Error_idError']);
    }

    protected static function converteerRijNaarCause($databaseRij) {
        return new Cause($databaseRij['idCause'], $databaseRij['CauseName']);
    }
}