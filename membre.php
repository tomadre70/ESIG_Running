<?php
$titre_page = "Espace Membre";
include 'header.inc.php';
include 'menu_membre.inc.php';
require_once 'config.php';

// Assurez-vous que la session est active
session_start();

// Récupération des données nécessaires
try {
    // Récupérer la liste des entraînements
    $stmtTrainings = $pdo->query("SELECT * FROM trainings ORDER BY date ASC, time ASC");
    $trainings = $stmtTrainings->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer la liste des utilisateurs ayant le rôle "Utilisateur"
    $stmtUsers = $pdo->query("SELECT id, name, surname, username FROM users WHERE role = 'Utilisateur' ORDER BY name ASC");
    $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les participants pour les entraînements créés par le membre connecté
    $stmtParticipants = $pdo->query("
    SELECT t.title, u.name, u.surname, u.username
    FROM registration r
    JOIN users u ON r.user_id = u.id
    JOIN trainings t ON r.training_id = t.id
    WHERE r.status = 'Inscrit'
    ORDER BY t.date ASC
");
$participants = $stmtParticipants->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<body class="bg-dark text-white">
    <header class="text-center p-3">
        <h1 style="color: red;">Bienvenue, <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Utilisateur'; ?> !</h1>
    </header>

    <main class="container mt-4">
        <div class="row">
            <!-- Section Ajouter un entraînement -->
            <section class="col-md-6 mb-4">
                <div class="p-3" style="border: 2px solid red; border-radius: 8px;">
                    <h2 class="text-center" style="color: red;">Ajouter un Entraînement</h2>
                    <form id="add-training-form" action="add_taining.php" method="POST">
                        <label for="title">Titre :</label>
                        <input type="text" id="title" name="title" class="form-control mb-3" required>
                        <label for="description">Description :</label>
                        <textarea id="description" name="description" class="form-control mb-3" required></textarea>
                        <label for="date">Date :</label>
                        <input type="date" id="date" name="date" class="form-control mb-3" required>
                        <label for="time">Heure :</label>
                        <input type="time" id="time" name="time" class="form-control mb-3" required>
                        <label for="location">Lieu :</label>
                        <input type="text" id="location" name="location" class="form-control mb-3" required>
                        <label for="max_participants">Nombre max de participants :</label>
                        <input type="number" id="max_participants" name="max_participants" class="form-control mb-3" required>
                        <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
                    </form>
                </div>
            </section>

            <!-- Section Liste des Entraînements -->
            <section class="col-md-6 mb-4">
                <div class="p-3" style="border: 2px solid red; border-radius: 8px;">
                    <h2 class="text-center" style="color: red;">Liste des Entraînements</h2>
                    <ul class="list-group">
                        <?php if (!empty($trainings)): ?>
                            <?php foreach ($trainings as $training): ?>
                                <li class="list-group-item bg-secondary text-white mb-2">
                                    <h4 class="text-info"><?= htmlspecialchars($training['title']); ?></h4>
                                    <p><strong>Description :</strong> <?= htmlspecialchars($training['description']); ?></p>
                                    <p><strong>Lieu :</strong> <?= htmlspecialchars($training['location']); ?></p>
                                    <p><strong>Date :</strong> <?= htmlspecialchars($training['date']); ?> à <?= htmlspecialchars($training['time']); ?></p>
                                    <p><strong>Participants Max :</strong> <?= htmlspecialchars($training['max_participants']); ?></p>
                                    <!-- Bouton Supprimer -->
                                    <form method="POST" action="delete_training.php" onsubmit="return confirm('Voulez-vous vraiment supprimer cet entraînement ?');">
                                        <input type="hidden" name="training_id" value="<?= htmlspecialchars($training['id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item bg-secondary text-muted">Aucun entraînement disponible pour l'instant.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>

            <!-- Section Liste des utilisateurs -->
            <section class="col-md-6 mb-4">
                <div class="p-3" style="border: 2px solid red; border-radius: 8px;">
                    <h2 class="text-center" style="color: red;">Liste des Utilisateurs</h2>
                    <ul class="list-group">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <li class="list-group-item bg-secondary text-white mb-2">
                                    <p><strong>Nom :</strong> <?= htmlspecialchars($user['name']); ?></p>
                                    <p><strong>Prénom :</strong> <?= htmlspecialchars($user['surname']); ?></p>
                                    <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['username']); ?></p>
                                    <form method="POST" action="promote_users.php">
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']); ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Promouvoir en Membre</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item bg-secondary text-muted">Aucun utilisateur trouvé.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>

            <!-- Section Liste des participants -->
            <section class="col-md-6 mb-4">
                <div class="p-3" style="border: 2px solid red; border-radius: 8px;">
                    <h2 class="text-center" style="color: red;">Participants à vos Entraînements</h2>
                    <ul class="list-group">
                        <?php if (!empty($participants)): ?>
                            <?php foreach ($participants as $participant): ?>
                                <li class="list-group-item bg-secondary text-white mb-2">
                                    <p><strong>Entraînement :</strong> <?= htmlspecialchars($participant['title']); ?></p>
                                    <p><strong>Nom :</strong> <?= htmlspecialchars($participant['name']); ?></p>
                                    <p><strong>Prénom :</strong> <?= htmlspecialchars($participant['surname']); ?></p>
                                    <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($participant['username']); ?></p>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item bg-secondary text-muted">Aucun participant trouvé.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>
        </div>
    </main>
</body>

