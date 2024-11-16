<?php
    $titre_page="Connexion";
    include 'header.inc.php';
?>
<body>
    <header>
        <h1>Bienvenue, <?= htmlspecialchars($_SESSION['username']); ?> !</h1>
    </header>
    <main class="container">
        <section class="trainings-section">
            <h2>Entraînements Disponibles</h2>
            <ul id="trainings-list">
                <?php if (!empty($trainings)): ?>
                    <?php foreach ($trainings as $training): ?>
                        <li>
                            <p><strong><?= htmlspecialchars($training['title']); ?></strong></p>
                            <p><?= htmlspecialchars($training['description']); ?></p>
                            <p><strong>Lieu :</strong> <?= htmlspecialchars($training['location']); ?></p>
                            <p><strong>Date :</strong> <?= htmlspecialchars($training['date']); ?> à <?= htmlspecialchars($training['time']); ?></p>
                            <form method="POST" action="">
                                <input type="hidden" name="training_id" value="<?= htmlspecialchars($training['id']); ?>">
                                <button type="submit">S'inscrire</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun entraînement disponible pour l'instant.</p>
                <?php endif; ?>
            </ul>
        </section>
    </main>
</body>