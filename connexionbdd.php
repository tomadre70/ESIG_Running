<?php
session_start();
require_once 'config.php'; // Inclusion du fichier de connexion

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        // Vérification des identifiants
        $stmt = $pdo->prepare("SELECT id, password_hash, role FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // password_verify($password, $user['password_hash'])
        if ($user && $password== $user['password_hash']) {
            // Stockage des informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Redirection vers une page utilisateur
            if ($_SESSION['role']== 'Membre'){
                header("Location: ./membre.php");
            }
            else{
                header("Location: ./utilisateur.php");
            }
            exit();
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>