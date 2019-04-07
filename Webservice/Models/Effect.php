<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:44
 */

class Effect
{
    public $idEffect;
    public $EffectName;
    public $EffectStatus;
    public $Error_idError;
    
    public function __construct($id, $naam, $status, $eff_errorid) {
        $this->idEffect = $id;
        $this->EffectName = $naam;
        $this->EffectStatus = $status;
        $this->Error_idError = $eff_errorid;
    }
}