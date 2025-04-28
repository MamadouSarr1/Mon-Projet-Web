<?php
require_once __DIR__ . '/Connexion.classe.php';


abstract class Select
{
    protected PDO $connexion;

    public function __construct()
    {
        $this->connexion = (new Connexion())->getConnexionBd();
    }

    abstract public function select();
    abstract public function selectMultiple();
}