<?php
    $titre_page="Connexion";
    include 'header.inc.php';
    include 'menu_membre.inc.php';
?>
<body>
    <main class="container">
        <!-- Section Formulaire -->
        <section class="form-section">
            <h2>Ajouter des Activités</h2>
            <form id="add-training-form" action="add_training.php" method="POST">
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" required>
                <br>
                <label for="description">Description :</label>
                <textarea id="description" name="description" required></textarea>
                <br>
                <label for="date">Date :</label>
                <input type="date" id="date" name="date" required>
                <br>
                <label for="time">Heure :</label>
                <input type="time" id="time" name="time" required>
                <br>
                <label for="location">Lieu :</label>
                <input type="text" id="location" name="location" required>
                <br>
                <label for="max_participants">Nombre max de participants :</label>
                <input type="number" id="max_participants" name="max_participants" required>
                <br>
                <button type="submit">Ajouter</button>
            </form>
        </section>

        <!-- Section Liste des Entraînements -->
        <section class="trainings-section">
            <h2>Liste des Entraînements</h2>
            <ul id="trainings-list">
                <!-- Exemple d'entraînements (sera remplacé dynamiquement) -->
                <li>
                    <button class="collapsible">Yoga Matinal - 20/11/2024</button>
                    <div class="content">
                        <p><strong>Description :</strong> Séance de yoga pour tous niveaux.</p>
                        <p><strong>Lieu :</strong> Salle A</p>
                        <p><strong>Heure :</strong> 08:00</p>
                        <p><strong>Participants Max :</strong> 20</p>
                    </div>
                </li>
                <li>
                    <button class="collapsible">Cardio Training - 21/11/2024</button>
                    <div class="content">
                        <p><strong>Description :</strong> Entraînement intensif en salle.</p>
                        <p><strong>Lieu :</strong> Salle B</p>
                        <p><strong>Heure :</strong> 18:00</p>
                        <p><strong>Participants Max :</strong> 15</p>
                    </div>
                </li>
            </ul>
        </section>
    </main>

    <script>
        // Script pour le menu dépliant
        document.addEventListener('DOMContentLoaded', function () {
            const coll = document.querySelectorAll('.collapsible');
            coll.forEach(button => {
                button.addEventListener('click', function () {
                    this.classList.toggle('active');
                    const content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            });

            // Simuler un entraînement ajouté
            const form = document.getElementById('add-training-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Empêcher le rechargement
                const title = document.getElementById('title').value;
                const description = document.getElementById('description').value;
                const date = document.getElementById('date').value;
                const time = document.getElementById('time').value;
                const location = document.getElementById('location').value;
                const maxParticipants = document.getElementById('max_participants').value;

                // Ajouter un nouvel entraînement
                const ul = document.getElementById('trainings-list');
                const li = document.createElement('li');
                li.innerHTML = `
                    <button class="collapsible">${title} - ${date}</button>
                    <div class="content">
                        <p><strong>Description :</strong> ${description}</p>
                        <p><strong>Lieu :</strong> ${location}</p>
                        <p><strong>Heure :</strong> ${time}</p>
                        <p><strong>Participants Max :</strong> ${maxParticipants}</p>
                    </div>`;
                ul.appendChild(li);

                // Activer le nouveau bouton dépliant
                li.querySelector('.collapsible').addEventListener('click', function () {
                    this.classList.toggle('active');
                    const content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });

                // Réinitialiser le formulaire
                form.reset();
            });
        });
    </script>
</body>