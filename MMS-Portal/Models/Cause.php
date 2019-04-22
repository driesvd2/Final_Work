<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:42
 */

class Cause {
    public $id;
    public $name;

    public function __construct($id, $naam) {
        $this->id = $id;
        $this->name = $naam;
    }

}

?>