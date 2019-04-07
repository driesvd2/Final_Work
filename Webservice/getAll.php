<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 17/03/2019
 * Time: 12:38
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Database/DAO/EffectDB.php';
include_once '../Database/DAO/UserDB.php';

$data = json_decode(file_get_contents("php://input"));


if (isset($data->credentials->login) && isset($data->credentials->pass)){
    if (UserDB::Login($data->credentials->login,$data->credentials->pass) == 0){
        $effects = EffectDB::getAll();

        if (sizeof($effects) > 0){
            http_response_code(200);
            echo json_encode($effects);
        }else
        {
            http_response_code(404);
            echo json_encode(
                array("message" => "No Effects found.")
            );
        }
    }else{
        http_response_code(401);
        echo json_encode(
            array("message" => "Unauthorized")
        );
        die();
    }
}else{
    http_response_code(401);
    echo json_encode(
        array("message" => "Unauthorized")
    );
    die();
}
?>
