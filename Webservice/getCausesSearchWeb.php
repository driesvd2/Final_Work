<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 02/04/2019
 * Time: 18:22
 */

include_once "./Database/DAO/ClusterDB.php";
include_once "./Database/DAO/CauseEffectDB.php";
include_once "./Database/DAO/CauseDB.php";
include_once './Database/DAO/EffectDB.php';
include_once './Database/DAO/UserDB.php';

class getCausesSearchWeb
{
    function combinations_set($set = [], $size = 0) {
        if ($size == 0) {
            return [[]];
        }

        if ($set == []) {
            return [];
        }


        $prefix = [array_shift($set)];

        $result = [];

        foreach (self::combinations_set($set, $size-1) as $suffix) {
            $result[] = array_merge($prefix, $suffix);
        }

        foreach (self::combinations_set($set, $size) as $next) {
            $result[] = $next;
        }

        return $result;
    }

    function combination_integer($n, $m) {
        return self::combinations_set(range(0, $n-1), $m);
    }

    function functionAPI($array){
        //$array = [2,7,8,14,22];
        $finalArray = array();
        $temparray = array();
        $temparray = array();
        $counter =0;
        $c = sizeof($array);
        for($i = $c; $i >= 1; $i--){
            //echo $i ." comb ".$c.":<br>";
            foreach (self::combination_integer($c, $i) as $combination) {
                foreach ($combination as $c) {
                    array_push($temparray, $array[$c]);
                }
                array_push($finalArray, $temparray);
                $temparray = array();
                $counter++;
            }
        }
        //echo $counter. "<br>";
        //var_dump($finalArray);
        //var_dump($causes);
        $causes = ClusterDB::getCausesForAPI($finalArray);
        $finalCauses = array();
        foreach ($causes as $c){
            if (!empty($c)){
                foreach ($c as $cause){
                    $cause = CauseDB::getById($cause->cause);
                    array_push($finalCauses, $cause[0]->id);
                }
            }
        }
        return $finalCauses;
    }

    function masterMind($effectenArray){
        $causes = array();
        if (sizeof($effectenArray) > 1){
            $array = array();
            foreach ($effectenArray as $e) {
                array_push($array, $e);
            }
            $ik = self::functionAPI($array);
            $ik = array_count_values($ik);
            arsort($ik);
            foreach ($ik as $key => $i) {
                array_push($causes, CauseDB::getById($key));
            }
            return $causes;
        } else if (sizeof($effectenArray) <= 1) {
            $causes1 = CauseEffectDB::getCausebyEffectId($effectenArray[0]);
            foreach ($causes1 as $c){
                $cause = CauseDB::getById($c->cause);
                array_push($causes, $cause);
            }
            return $causes;
        }
        return $causes;
    }

}