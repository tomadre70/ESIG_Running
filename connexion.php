<?php
    $titre_page="Connexion";
    include 'header.inc.php';
?>

<section class="centered-container">
    <h1>Connexion Utilisateur</h1>
    <form action="./connexionbdd.php" method = "POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Se connecter</button>
    </form>
    <a href="./accueil.php"><h2>Retour à l'accueil</h2></a>
</section>
