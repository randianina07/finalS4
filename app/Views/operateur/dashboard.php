<?= $this->extend('layouts/operateur') ?>

<?= $this->section('content') ?>

    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label">Clients enregistrés</div>
            <div class="stat-value"><?= $nbClients ?></div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Opérations effectuées</div>
            <div class="stat-value"><?= $nbOperations ?></div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Gains cumulés (frais)</div>
            <div class="stat-value"><?= number_format($totalGains, 0, ',', ' ') ?> Ar</div>
        </div>
    </div>

    <div class="actions-grid">
        <a href="/operateur/clients" class="action-card">
            <span class="action-icon">👥</span>
            Clients
        </a>
        <a href="/operateur/gains" class="action-card">
            <span class="action-icon">📊</span>
            Gains
        </a>
        <a href="/operateur/baremes" class="action-card">
            <span class="action-icon">📐</span>
            Barèmes
        </a>
        <a href="/operateur/prefixes" class="action-card">
            <span class="action-icon">📶</span>
            Préfixes
        </a>
    </div>

<?= $this->endSection() ?>
