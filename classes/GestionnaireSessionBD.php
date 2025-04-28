<?php
class GestionnaireSessionBD implements SessionHandlerInterface {
    private $connexionBD;

    public function __construct($connexionBD) {
        $this->connexionBD = $connexionBD;
    }

    public function open(string $cheminSauvegarde, string $nomSession): bool {
        // Rien à faire ici, la connexion PDO est déjà établie
        return true;
    }

    public function close(): bool {
        // Rien à faire ici, la connexion PDO sera fermée automatiquement
        return true;
    }

    public function read(string $idSession): string|false {
        $requete = $this->connexionBD->prepare("SELECT donnees FROM sessions WHERE id_session = :id_session");
        $requete->execute(['id_session' => $idSession]);
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        return $resultat ? $resultat['donnees'] : '';
    }

    public function write(string $idSession, string $donnees): bool {
        $requete = $this->connexionBD->prepare("REPLACE INTO sessions (id_session, donnees, derniere_acces) VALUES (:id_session, :donnees, NOW())");
        return $requete->execute(['id_session' => $idSession, 'donnees' => $donnees]);
    }

    public function destroy(string $idSession): bool {
        $requete = $this->connexionBD->prepare("DELETE FROM sessions WHERE id_session = :id_session");
        return $requete->execute(['id_session' => $idSession]);
    }

    public function gc(int $dureeMax): int|false {
        $requete = $this->connexionBD->prepare("DELETE FROM sessions WHERE derniere_acces < NOW() - INTERVAL :duree_max SECOND");
        $requete->execute(['duree_max' => $dureeMax]);
        return $requete->rowCount();
    }
}
?>