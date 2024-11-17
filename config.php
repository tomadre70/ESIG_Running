<?php
// Configuration des paramètres de connexion
$host = 'localhost'; // Adresse du serveur MySQL
$dbname = 'bdd_running'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur MySQL
$password = 'root'; // Mot de passe MySQL (vide par défaut sur certains environnements locaux)

try {
    // Création d'une instance PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configuration des attributs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données.";
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}
?>