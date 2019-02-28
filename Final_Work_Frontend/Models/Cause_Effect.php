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
    public $Cause_idCause;
    public $Effect_idEffect;

    public function __construct($id, $Cause_id, $Effect_id) {
        $this->id = $id;
        $this->Cause_idCause = $Cause_id;
        $this->Effect_idEffect = $Effect_id;
    }
}