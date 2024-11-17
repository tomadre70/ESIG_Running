<?php
require_once 'config.php'; // Connexion à la base de données
session_start();

// Vérifiez si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si l'utilisateur connecté est autorisé
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Membre') {
        echo "Accès refusé.";
        exit;
    }

    // Récupération de l'ID de l'utilisateur à promouvoir
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;

    if (!$userId) {
        echo "Utilisateur non spécifié.";
        exit;
    }

    try {
        // Commencez une transaction pour consigner la promotion
        $pdo->beginTransaction();

        // Récupérez l'utilisateur à promouvoir
        $stmt = $pdo->prepare("SELECT role FROM bdd_running.users WHERE id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || $user['role'] !== 'Utilisateur') {
            echo "Utilisateur introuvable ou déjà promu.";
            $pdo->rollBack(); // Annule la transaction
            exit;
        }

        // Mettez à jour le rôle de l'utilisateur
        $stmt = $pdo->prepare("UPDATE bdd_running.users SET role = 'Membre' WHERE id = :user_id");
        $stmt->execute([':user_id' => $userId]);

        // Ajoutez l'entrée dans la table `role_promotions`
        $stmt = $pdo->prepare("
            INSERT INTO bdd_running.role_promotions (promoted_by, promoted_user, previous_role, promotion_date)
            VALUES (:promoted_by, :promoted_user, :previous_role, NOW())
        ");
        $stmt->execute([
            ':promoted_by' => $_SESSION['user_id'], // ID de l'utilisateur qui fait la promotion
            ':promoted_user' => $userId,
            ':previous_role' => 'Utilisateur'
        ]);

        // Validez la transaction
        $pdo->commit();

        echo "Promotion effectuée avec succès.";
        header("Location: membre.php"); // Redirige vers la page membre
        exit;
    } catch (PDOException $e) {
        $pdo->rollBack(); // Annule la transaction en cas d'erreur
        die("Erreur : " . $e->getMessage());
    }
} else {
    echo "Méthode non autorisée.";
}
?>