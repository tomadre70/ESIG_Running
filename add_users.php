<?php
session_start();
require_once 'config.php';

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Veuillez vous connecter pour accéder à cette page.");
}

// Récupération des entraînements disponibles
try {
    $stmt = $pdo->query("SELECT * FROM trainings WHERE date >= CURDATE() ORDER BY date ASC");
    $trainings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des entraînements : " . $e->getMessage());
}

// Gestion de l'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $trainingId = (int)$_POST['training_id'];

    try {
        // Vérifiez si l'utilisateur est déjà inscrit
        $checkStmt = $pdo->prepare("
            SELECT * FROM registrations WHERE user_id = :user_id AND training_id = :training_id AND status = 'Inscrit'
        ");
        $checkStmt->execute([
            ':user_id' => $userId,
            ':training_id' => $trainingId
        ]);

        if ($checkStmt->rowCount() > 0) {
            echo "<p>Vous êtes déjà inscrit à cet entraînement.</p>";
        } else {
            // Inscription
            $stmt = $pdo->prepare("
                INSERT INTO registrations (user_id, training_id, status) 
                VALUES (:user_id, :training_id, 'Inscrit')
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':training_id' => $trainingId
            ]);
            echo "<p>Inscription réussie !</p>";
        }
    } catch (PDOException $e) {
        die("Erreur lors de l'inscription : " . $e->getMessage());
    }
}
?>