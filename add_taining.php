<?php
session_start();
require_once 'config.php'; // Inclusion du fichier de connexion

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = trim($_POST['location']);
    $max_participants = (int)$_POST['max_participants'];

    // Vérifiez que l'utilisateur est connecté et qu'il a le droit de créer un entraînement
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Membre') {
        die("Accès refusé.");
    }

    try {
        // Insertion de l'entraînement
        $stmt = $pdo->prepare("INSERT INTO trainings (title, description, date, time, location, max_participants, created_by) VALUES (:title, :description, :date, :time, :location, :max_participants, :created_by)");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':date' => $date,
            ':time' => $time,
            ':location' => $location,
            ':max_participants' => $max_participants,
            ':created_by' => $_SESSION['user_id']
        ]);

        echo "Entraînement ajouté avec succès.";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>