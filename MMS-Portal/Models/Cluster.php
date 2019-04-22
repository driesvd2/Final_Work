<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 20/02/2019
 * Time: 21:30
 */

class Cluster
{
    public $id;
    public $cause;
    public $effects;

    public function __construct($id, $cause, $effects) {
        $this->id = $id;
        $this->cause = $cause;
        $this->effects = $effects;
    }
}