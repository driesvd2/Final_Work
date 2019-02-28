<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:42
 */

class Cause {
    public $idCause;
    public $CauseName;

    public function __construct($id, $naam) {
        $this->idCause = $id;
        $this->CauseName = $naam;
    }

}

?>