<?php
session_start();
require_once 'config.php'; // Fichier contenant les informations de connexion à la base

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=bdd_running', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier les champs obligatoires
        if (empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['id']) || empty($_POST['pwd']) || empty($_POST['type'])) {
            die("Tous les champs doivent être remplis !");
        }

        // Récupérer les données du formulaire
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $age = isset($_POST['age']) ? (int)$_POST['age'] : null;
        $username = $_POST['id'];
        $password = $_POST['pwd']; // Pas de hachage ici
        $gender = $_POST['type'];

        // Vérifier si l'utilisateur existe déjà
        $checkUser = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $checkUser->execute([':username' => $username]);
        if ($checkUser->fetchColumn() > 0) {
            die("Cet identifiant est déjà utilisé.");
        }

        // Insérer l'utilisateur dans la base
        $sql = "INSERT INTO users (name, surname, age, username, password_hash, gender, role) 
                VALUES (:name, :surname, :age, :username, :password, :gender, 'Utilisateur')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':surname' => $surname,
            ':age' => $age,
            ':username' => $username,
            ':password' => $password, // Le mot de passe en clair est inséré
            ':gender' => $gender
        ]);

        // Rediriger vers la page de connexion après un succès
        header("Location: ./connexion.php");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message
        die("Erreur : " . $e->getMessage());
    }
} else {
    echo "Méthode non autorisée.";
}

