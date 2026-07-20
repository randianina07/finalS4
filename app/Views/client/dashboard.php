<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <div class="solde-card">
        <div class="label">Solde disponible</div>
        <div class="montant"><?= number_format($solde, 0, ',', ' ') ?> Ar</div>
        <div class="numero">Numéro : <?= esc($numero) ?></div>
    </div>

    <div class="actions-grid">
        <a href="/client/depot" class="action-card">
            <span class="action-icon">💰</span>
            Dépôt
        </a>
        <a href="/client/retrait" class="action-card">
            <span class="action-icon">🏧</span>
            Retrait
        </a>
        <a href="/client/transfert" class="action-card">
            <span class="action-icon">🔄</span>
            Transfert
        </a>
        <a href="/client/historique" class="action-card">
            <span class="action-icon">📜</span>
            Historique
        </a>
    </div>

<?= $this->endSection() ?>
