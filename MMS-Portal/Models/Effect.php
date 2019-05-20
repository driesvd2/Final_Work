<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:44
 */

class Effect
{
    public $id;
    public $name;
    public $status;
    public $tag;


    public function __construct($id, $naam, $status, $tag)
    {
        $this->id = $id;
        $this->name = $naam;
        $this->status = $status;
        $this->tag = $tag;
    }
}
