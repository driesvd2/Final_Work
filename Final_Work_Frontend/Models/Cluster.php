<?php
/**
 * Created by PhpStorm.
 * User: Dries
 * Date: 20/02/2019
 * Time: 21:30
 */

class Cluster
{
    public $idCluster;
    public $Cause_idCause;
    public $Cluster_Effects;

    public function __construct($idCluster, $Cause_idCause, $Cluster_Effects) {
        $this->idCluster = $idCluster;
        $this->Cause_idCause = $Cause_idCause;
        $this->Cluster_Effects = $Cluster_Effects;
    }
}