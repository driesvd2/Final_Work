<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:46
 */

class Cause_Effect
{
    public $id;
    public $cause;
    public $effect;

    public function __construct($id, $Cause_id, $Effect_id) {
        $this->id = $id;
        $this->cause = $Cause_id;
        $this->effect = $Effect_id;
    }
}