<?php
session_start();
require_once 'config.php'; // Inclure la connexion à la base

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $registration_id = $_POST['registration_id']; // ID de l'inscription à annuler

        // Mettre à jour le statut de l'inscription
        $stmtUnregister = $pdo->prepare("
            UPDATE registration 
            SET status = 'Désinscrit' 
            WHERE id = :registration_id
        ");
        $stmtUnregister->execute([':registration_id' => $registration_id]);

        header("Location: utilisateur.php"); // Redirection après désinscription
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la désinscription : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}