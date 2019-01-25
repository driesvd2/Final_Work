<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:46
 */

class Cause_Effect
{
    public $Cause_idCause;
    public $Effect_idEffect;

    public function __construct($Cause_id, $Effect_id) {
        $this->Cause_idCause = $Cause_id;
        $this->Effect_idEffect = $Effect_id;
    }
}