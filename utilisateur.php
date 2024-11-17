<?php
$titre_page = "Entraînements";
include 'header.inc.php';
include 'menu_membre.inc.php'; // Inclure l'en-tête
require_once 'config.php'; // Connexion à la base de données

// Assurez-vous que la session est active
session_start();

// Récupérer les données des entraînements et du planning
try {
    // Récupérer les entraînements disponibles avec le nombre de places restantes
    $stmtTrainings = $pdo->query("
        SELECT t.*, 
               (t.max_participants - COALESCE(SUM(r.status = 'Inscrit'), 0)) AS remaining_places 
        FROM trainings t
        LEFT JOIN registration r ON t.id = r.training_id
        GROUP BY t.id
        ORDER BY t.date, t.time
    ");
    $trainings = $stmtTrainings->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les entraînements auxquels l'utilisateur est inscrit
    $stmtUserTrainings = $pdo->prepare("
        SELECT r.id AS registration_id, t.id AS training_id, t.title, t.date, t.time, t.location 
        FROM registration r
        JOIN trainings t ON r.training_id = t.id
        WHERE r.user_id = :user_id AND r.status = 'Inscrit'
        ORDER BY t.date, t.time
    ");
    $stmtUserTrainings->execute([':user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0]);
    $userTrainings = $stmtUserTrainings->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<body class="bg-dark text-white">
    <header class="text-center p-3">
        <h1 style="color: red;">Bienvenue, <?= htmlspecialchars(isset($_SESSION['username']) ? $_SESSION['username'] : 'Utilisateur'); ?> !</h1>
    </header>

    <main class="container mt-4">
        <div class="row">
            <!-- Entraînements disponibles -->
            <section class="col-md-5">
                <div class="p-3 mb-5" style="border: 2px solid violet; border-radius: 8px;">
                    <h2 class="text-center" style="color: red;">Entraînements Disponibles</h2>
                    <div class="accordion" id="trainingsAccordion">
                        <?php if (!empty($trainings)): ?>
                            <?php foreach ($trainings as $key => $training): ?>
                                <div class="accordion-item bg-secondary text-white">
                                    <h2 class="accordion-header" id="heading<?= $key; ?>">
                                        <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key; ?>" aria-expanded="false" aria-controls="collapse<?= $key; ?>">
                                            <?= htmlspecialchars($training['title']); ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $key; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $key; ?>" data-bs-parent="#trainingsAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Description :</strong> <?= htmlspecialchars($training['description']); ?></p>
                                            <p><strong>Lieu :</strong> <?= htmlspecialchars($training['location']); ?></p>
                                            <p><strong>Date :</strong> <?= htmlspecialchars($training['date']); ?> à <?= htmlspecialchars($training['time']); ?></p>
                                            <p><strong>Places restantes :</strong> <?= htmlspecialchars($training['remaining_places']); ?></p>
                                            <?php if ($training['remaining_places'] > 0): ?>
                                                <form method="POST" action="register_training.php">
                                                    <input type="hidden" name="training_id" value="<?= htmlspecialchars($training['id']); ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm">S'inscrire</button>
                                                </form>
                                            <?php else: ?>
                                                <p class="text-danger">Nombre de participants dépassé.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="accordion-item bg-secondary text-muted">
                                <p class="p-3">Aucun entraînement disponible pour l'instant.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Planning de l'utilisateur -->
            <section class="col-md-7">
                <div class="p-3" style="border: 2px solid violet; border-radius: 8px;">
                    <h2 class="text-center" style="color: red;">Votre Planning</h2>
                    <ul class="list-group">
                        <?php if (!empty($userTrainings)): ?>
                            <?php foreach ($userTrainings as $userTraining): ?>
                                <li class="list-group-item bg-secondary text-white mb-3">
                                    <h4 class="text-info"><?= htmlspecialchars($userTraining['title']); ?></h4>
                                    <p><strong>Lieu :</strong> <?= htmlspecialchars($userTraining['location']); ?></p>
                                    <p><strong>Date :</strong> <?= htmlspecialchars($userTraining['date']); ?> à <?= htmlspecialchars($userTraining['time']); ?></p>
                                    <form method="POST" action="unregister_training.php">
                                        <input type="hidden" name="registration_id" value="<?= htmlspecialchars($userTraining['registration_id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Se désinscrire</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item bg-secondary text-muted">Vous n'êtes inscrit à aucun entraînement pour l'instant.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>
        </div>
    </main>
</body>