<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainingId = isset($_POST['training_id']) ? intval($_POST['training_id']) : 0;

    if ($trainingId <= 0) {
        die("ID d'entraînement invalide.");
    }

    try {
        // Supprimer l'entraînement sans vérifier l'auteur
        $stmt = $pdo->prepare("DELETE FROM trainings WHERE id = :id");
        $stmt->execute([':id' => $trainingId]);

        // Vérifier si une ligne a été supprimée
        if ($stmt->rowCount() > 0) {
            header("Location: membre.php?message=training_deleted");
            exit;
        } else {
            die("Impossible de supprimer cet entraînement. Il peut ne pas exister.");
        }
    } catch (PDOException $e) {
        die("Erreur SQL : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}