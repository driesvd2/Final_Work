<?php

/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:36
 */

class Database {

    protected $computernaam;
    protected $gebruikersnaam;
    protected $wachtwoord;
    protected $databasenaam;
    protected $mijnVerbinding = null;

    public function __construct($computernaam, $gebruikersnaam, $wachtwoord, $databasenaam) {
        $this->computernaam = $computernaam;
        $this->gebruikersnaam = $gebruikersnaam;
        $this->wachtwoord = $wachtwoord;
        $this->databasenaam = $databasenaam;
    }

    public function __destruct() {
        if ($this->mijnVerbinding != null) {
            $this->verbreekVerbindingMetDatabase();
        }
    }

    protected function maakVerbindingMetDatabase() {
        $this->mijnVerbinding = new mysqli($this->computernaam, $this->gebruikersnaam, $this->wachtwoord, $this->databasenaam);
        if ($this->mijnVerbinding->connect_error) {
            die("Connect Error (" . $this->mijnVerbinding->connect_errno . ") " . $this->mijnVerbinding->connect_error);
        }
    }

    protected function verbreekVerbindingMetDatabase() {
        if ($this->mijnVerbinding != null) {
            $this->mijnVerbinding->close();
            $this->mijnVerbinding = null;
        }
    }

    protected function voorkomSqlInjection($parameterWaarde) {
        $resultaat = $this->mijnVerbinding->real_escape_string($parameterWaarde);
        return $resultaat;
    }

    public function voerSqlQueryUit($mijnSqlQuery) {
        return $this->voerAdvancedSqlQueryUit($mijnSqlQuery);
    }

    protected function voerAdvancedSqlQueryUit($mijnSqlQuery) {
        $verbindingAutomatischVerbreken = true;
        $parameterArray = null;
        $this->maakVerbindingMetDatabase();
        if ($parameterArray != null) {
            //Verander alle vraagtekens in de query door parameterwaarden uit de parameterArray
            $queryParts = preg_split("/\?/", $mijnSqlQuery);
            if (count($queryParts) != count($parameterArray) + 1) {
                return false;
            }
            $uiteindelijkeQuery = $queryParts[0];
            for ($index = 0; $index < count($parameterArray); $index++) {
                $uiteindelijkeQuery = $uiteindelijkeQuery . $this->voorkomSqlInjection($parameterArray[$index]) . $queryParts[$index + 1];
            }
            $mijnSqlQuery = $uiteindelijkeQuery;
        }

        $resultaat = $this->mijnVerbinding->query($mijnSqlQuery);
        if ($verbindingAutomatischVerbreken) {
            $this->verbreekVerbindingMetDatabase();
        }
        return $resultaat;
    }

}

?>