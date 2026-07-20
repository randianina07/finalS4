<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Espace Client' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <div class="container">

        <header class="header-client">

            <h1>
                Espace Client
            </h1>

            <nav>
                <a href="/c lient/dashboard">
                    Accueil
                </a>

                <a href="/client/depot">
                    Dépôt
                </a>

                <a href="/client/retrait">
                    Retrait
                </a>

                <a href="/client/transfert">
                    Transfert
                </a>

                <a href="/client/historique">
                    Historique
                </a>

                <a href="/logout">
                    Déconnexion
                </a>
            </nav>

        </header>



        <!-- Messages -->
        <?php if(session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>

        <?php endif; ?>


        <?php if(session()->getFlashdata('success')): ?>

            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>

        <?php endif; ?>



        <!-- Contenu des pages -->
        <?= $this->renderSection('content') ?>


    </div>

</body>
</html>