<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 25/01/2019
 * Time: 01:20
 */

class User
{
    public $userId;
    public $username;
    public $password;
    public $userType;

    public function __construct($userId, $username, $password, $userType) {
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->userType = $userType;
    }
}