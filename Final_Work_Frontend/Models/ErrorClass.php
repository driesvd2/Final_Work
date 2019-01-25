<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:45
 */

class ErrorClass
{
    public $idError;
    public $Message;

    public function __construct($id, $message) {
        $this->idError = $id;
        $this->Message = $message;
    }
}