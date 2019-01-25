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
    public $CauseDescription;

    public function __construct($id, $naam, $beschrijving) {
        $this->idCause = $id;
        $this->CauseName = $naam;
        $this->CauseDescription = $beschrijving;
    }

}

?>