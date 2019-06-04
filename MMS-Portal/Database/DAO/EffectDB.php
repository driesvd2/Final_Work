<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 21:48
 */

include_once "Models/Effect.php";
include_once "Database/DatabaseFactory.php";

class EffectDB
{

    private static function getVerbinding()
    {
        return DatabaseFactory::getDatabase();
    }

    public static function getAllWhereTag($tag)
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect WHERE tag='$tag' ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getAllWhereTagWithStatus2($tag)
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect WHERE tag='$tag' AND status=1 ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllColumnsOfEffect()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT column_name FROM information_schema.columns WHERE table_schema = '1819FW_DRIESD_STEFANOSS' AND table_name = 'Effect'");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $result = $resultaat->fetch_array();
            $resultatenArray[$index] = $result["column_name"];
        }
        return $resultatenArray;
    }

    public static function getAllMetaColumnsOfEffect()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT column_name FROM information_schema.columns WHERE table_schema = '1819FW_DRIESD_STEFANOSS' AND table_name = 'Effect' AND column_name != 'id' AND column_name != 'tag' AND column_name != 'name' AND column_name != 'status'");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $result = $resultaat->fetch_array();
            $resultatenArray[$index] = $result["column_name"];
        }
        return $resultatenArray;
    }

    public static function getAllStandardColumnsOfEffect()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT column_name FROM information_schema.columns WHERE table_schema = '1819FW_DRIESD_STEFANOSS' AND table_name = 'Effect' and ordinal_position <= 4 AND column_name != 'status'");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $result = $resultaat->fetch_array();
            $resultatenArray[$index] = $result["column_name"];
        }
        return $resultatenArray;
    }

    public static function addColumnEffect($name)
    {
        return self::getVerbinding()->voerSqlQueryUit('ALTER TABLE Effect ADD ' . $name . ' VARCHAR(1500) NULL');
    }

    public static function deleteColumnEffect($name)
    {
        return self::getVerbinding()->voerSqlQueryUit('ALTER TABLE Effect DROP COLUMN ' . $name);
    }

    public static function editColumnEffect($old, $name)
    {
        return self::getVerbinding()->voerSqlQueryUit('ALTER TABLE Effect Change COLUMN ' . $old . ' ' . $name . ' VARCHAR(1500) ');
    }

    public static function getAll()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }




    public static function getAllWhereStatusIsOneAndTwo()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where (status = 1) OR (status = 2) ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


    public static function getAllStatusZero()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where status=0 ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllStatusOne()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where status=1 ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getById($id)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect WHERE id=" . $id . " ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


    public static function getByIdMeta($id)
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect WHERE id=" . $id . " ORDER BY id ASC");
        $result = $resultaat->fetch_array();
        return $result;
    }

    public static function getSearchEffect($searchq, $column)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Effect where " . $column . " LIKE '%$searchq%' ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getSearchEffectStatus0($searchq, $column)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Effect where " . $column . " LIKE '%$searchq%' AND status = 0 ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getSearchEffectStatus1($searchq, $column)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Effect where " . $column . " LIKE '%$searchq%' AND status = 1 ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


    public static function getSearchEffectID($searchq)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select id from Effect where name LIKE '%$searchq%' ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }



    public static function getSearchEffectWhereStatusNotZero($searchq)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Effect where name LIKE '%$searchq%' AND status != 0 ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


    public static function setStatus1($effectId, $effectName)
    {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET status=1, name='$effectName' WHERE id=" . $effectId);
    }

    public static function setStatus1AfterDelete($effectId)
    {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET status=1 WHERE id=" . $effectId);
    }

    public static function setStatus2($effectId)
    {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET status=2 WHERE id=" . $effectId);
    }
 
    public static function getByName($effectName){
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Effect where name = '$effectName'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function insert($effectname,$tag)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Effect(id, name, status, tag) VALUES (null ,'$effectname', 1, '$tag')");
    }

    public static function insertNewEffect($id, $effectname, $effectstatus,$tag)
    {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET name = '$effectname', status =  $effectstatus, tag = $tag  WHERE id=" . $id);
    }

    public static function deleteById($id)
    {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Effect WHERE id=" . $id);
    }

    public static function update($array, $id)
    {
        $query = "UPDATE Effect SET ";
        foreach ($array as $key => $value) {
            $query .= " " . $key . " = '$value', ";
        }
        $query = substr($query, 0, -2);


        $query .= " where id =" . $id;

        //var_dump($query);

        return self::getVerbinding()->voerSqlQueryUit($query);
    }


    protected static function converteerRijNaarEffect($databaseRij)
    {
        return new Effect($databaseRij['id'], $databaseRij['name'], $databaseRij['status'], $databaseRij['tag']);
    }
}
