<?php

require_once __DIR__ . '/Select.abstract.php';
require_once __DIR__ . '/Utilisateur.php';

class SelectUtilisateur extends Select
{
    private string $courriel;
    private Utilisateur $user;

    public function __construct(string $courriel)
    {
        $this->courriel = $courriel;
        $this->user = new Utilisateur();
        parent::__construct();
    }

    public function select()
    {
        $stmt = $this->connexion->prepare("SELECT * FROM utilisateurs WHERE email = :mail");
        $stmt->bindParam(':mail', $this->courriel, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->user->setId($row['id']);
            $this->user->setNom($row['nom']);
            $this->user->setCourriel($row['email']);
            $this->user->setMdp($row['mot_de_passe']);
            $this->user->setRole($row['role']);
            return $this->user;
        }

        return null;
    }

    public function selectMultiple()
    {
        $utilisateurs = [];
        $stmt = $this->connexion->query("SELECT * FROM utilisateurs");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new Utilisateur();
            $user->setId($row['id']);
            $user->setNom($row['nom']);
            $user->setCourriel($row['email']);
            $user->setMdp($row['mot_de_passe']);
            
            $utilisateurs[] = $user;
        }

        return $utilisateurs;
    }
}
