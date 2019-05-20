<?php

class Tag
{
    public $id;
    public $name;
    public $parent;

    public function __construct($id, $name, $parent)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parent = $parent;
    }
}
