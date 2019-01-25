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
    public $EffectDescription;

    public function __construct($id, $naam, $beschrijving) {
        $this->idEffect = $id;
        $this->EffectName = $naam;
        $this->EffectDescription = $beschrijving;
    }
}