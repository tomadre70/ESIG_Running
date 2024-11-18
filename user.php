<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Utilisateur - ESIG'RUNNING</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Lien vers Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Bienvenue sur votre interface</h1>
        <div class="row g-4">
            <!-- Section : Accéder aux entraînements -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste des entraînements</h5>
                        <p class="card-text">Consultez les entraînements proposés par les membres de l'association.</p>
                        <a href="entrainements.php" class="btn btn-primary">Voir les entraînements</a>
                    </div>
                </div>
            </div>

            <!-- Section : Inscription aux entraînements -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">S'inscrire à un entraînement</h5>
                        <p class="card-text">Rejoignez un entraînement en vous inscrivant dès maintenant.</p>
                        <a href="inscription_entrainement.php" class="btn btn-success">S'inscrire</a>
                    </div>
                </div>
            </div>

            <!-- Section : Désinscription -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Se désinscrire</h5>
                        <p class="card-text">Si vous changez d'avis, désinscrivez-vous d'un entraînement.</p>
                        <a href="desinscription.php" class="btn btn-danger">Se désinscrire</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <!-- Lien vers Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
