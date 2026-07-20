<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Espace Opérateur' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body class="app-body">

    <div class="app-shell">

        <header class="topbar">
            <div class="brand">Mobile<span>Money</span> · Opérateur</div>
            <nav>
                <a href="/operateur/dashboard">Tableau de bord</a>
                <a href="/operateur/clients">Clients</a>
                <a href="/operateur/gains">Gains</a>
                <a href="/operateur/montants">Montants</a>
                <a href="/operateur/baremes">Barèmes</a>
                <a href="/operateur/prefixes">Préfixes</a>
                <a href="/operateur/reseaux">Réseaux</a>
                <a href="/logout" class="logout">Déconnexion</a>
            </nav>
        </header>

        <!-- Messages -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <!-- Contenu des pages -->
        <?= $this->renderSection('content') ?>

    </div>

</body>
</html>
