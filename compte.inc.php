<?php
$titre_page = "Inscription";
include 'header.inc.php';
?>

<section class="centered-container">
    <h2>Inscription</h2>
    <form id="registration-form" method="POST" action="add_users.php">
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" placeholder="Saisissez votre Nom" required />
        <br />

        <label for="surname">Prénom</label>
        <input type="text" id="surname" name="surname" placeholder="Saisissez votre Prénom" required />
        <br />

        <label for="age">Entrer votre âge</label>
        <input type="number" id="age" name="age" value="17" required />
        <br />

        <label for="id">Identifiant</label>
        <input type="text" id="id" name="id" placeholder="Entrer votre nomPrenom comme id" required />
        <br />

        <label for="pwd">Mot de passe</label>
        <input type="password" id="pwd" name="pwd" placeholder="Créer votre mot de passe" required />
        <br />

        <div>
            <input type="radio" name="type" id="male" value="Homme" required />
            <label for="male">Homme</label>

            <input type="radio" name="type" id="female" value="Femme" />
            <label for="female">Femme</label>

            <input type="radio" name="type" id="other" value="Autre" />
            <label for="other">Autre</label>
        </div>

        <input type="submit" value="S'inscrire" />
    </form>
    <a href="./accueil.php"><h2>Retour à l'accueil</h2></a>
</section>