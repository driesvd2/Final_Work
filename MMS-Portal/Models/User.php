<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 25/01/2019
 * Time: 01:20
 */

class User
{
    public $id;
    public $username;
    public $password;
    public $type;

    public function __construct($id, $username, $password, $type) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->type = $type;
    }
}

?>