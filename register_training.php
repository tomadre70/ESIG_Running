<?php
session_start();
require_once 'config.php'; // Inclure la connexion à la base

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $training_id = $_POST['training_id']; // ID de l'entraînement sélectionné
        $user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté

        // Vérifier si l'utilisateur est déjà inscrit
        $stmtCheck = $pdo->prepare("
            SELECT COUNT(*) 
            FROM registration 
            WHERE user_id = :user_id AND training_id = :training_id AND status = 'Inscrit'
        ");
        $stmtCheck->execute([':user_id' => $user_id, ':training_id' => $training_id]);

        if ($stmtCheck->fetchColumn() > 0) {
            die("Vous êtes déjà inscrit à cet entraînement.");
        }

        // Ajouter une inscription
        $stmtRegister = $pdo->prepare("
            INSERT INTO registration (user_id, training_id, registration_date, status) 
            VALUES (:user_id, :training_id, NOW(), 'Inscrit')
        ");
        $stmtRegister->execute([':user_id' => $user_id, ':training_id' => $training_id]);

        header("Location: utilisateur.php"); // Redirection après l'inscription
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'inscription : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}