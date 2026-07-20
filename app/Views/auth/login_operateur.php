<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Opérateur</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <div class="container">
        <h1>Espace Opérateur</h1>
        <p>Connectez-vous avec vos identifiants</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/login/operateur" method="post">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit" class="btn btn-submit">Se connecter</button>
        </form>

        <a href="/" class="back-link">&larr; Retour à l'accueil</a>
    </div>

</body>
</html>