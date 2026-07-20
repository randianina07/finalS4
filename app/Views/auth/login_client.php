<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Client</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <div class="container">
        <h1>Espace Client</h1>
        <p>Connectez-vous avec votre numéro de téléphone</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/login/client" method="post">
            <div class="form-group">
                <label for="telephone">Numéro de téléphone</label>
                <input type="tel" id="telephone" name="telephone" required>
            </div>
            <button type="submit" class="btn btn-submit">Se connecter</button>
        </form>

        <a href="/" class="back-link">&larr; Retour à l'accueil</a>
    </div>

</body>
</html>