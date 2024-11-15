<?php
    $titre_page="Connexion";
    include 'header.inc.php';
?>

<section class="centered-container">
    <h1>Connexion Utilisateur</h1>
    <form action="">
        <label for="id">Identifiant</label>
        <input type="text" id="id" 
        placeholder="Entrer votre identifiant" />
        <br/>
        
        <label for="pwd">Mot de passe</label>
        <input type="password" id="pwd" 
        placeholder="Mot de passe" />

        <br />
        
        <input type="submit" value="Connexion"/>
    </form>
    <a href="./accueil.php"><h2>Retour à l'accueil</h2></a>
</section>
