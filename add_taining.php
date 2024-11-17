<?php
session_start();
require_once 'config.php'; // Fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bdd_running', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $title = $_POST['title'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $maxParticipants = (int)$_POST['max_participants'];

        $sql = "INSERT INTO trainings (title, description, date, time, location, max_participants) 
                VALUES (:title, :description, :date, :time, :location, :maxParticipants)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':date' => $date,
            ':time' => $time,
            ':location' => $location,
            ':maxParticipants' => $maxParticipants
        ]);

        echo "Entraînement ajouté avec succès.";
    } catch (PDOException $e) {
        http_response_code(500); // Erreur serveur
        echo "Erreur : " . $e->getMessage();
    }
} else {
    http_response_code(405); // Méthode non autorisée
    echo "Méthode non autorisée.";
}
