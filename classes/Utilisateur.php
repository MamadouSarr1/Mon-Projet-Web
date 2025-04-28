<?php

class Utilisateur
{
    private int $id;
    private string $nom;
    private string $courriel;
    private string $motDePasse;
    private string $role = 'user'; // Par défaut "user"

    // --- ID ---
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    // --- Nom ---
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getNom(): string {
        return $this->nom;
    }

    // --- Courriel ---
    public function setCourriel(string $courriel): void {
        $this->courriel = $courriel;
    }

    public function getCourriel(): string {
        return $this->courriel;
    }

    // --- Mot de passe ---
    public function setMdp(string $motDePasse): void {
        $this->motDePasse = $motDePasse;
    }

    public function getMdp(): string {
        return $this->motDePasse;
    }

    // --- Rôle ---
    public function setRole(string $role): void {
        $this->role = $role;
    }

    public function getRole(): string {
        return $this->role;
    }
}
