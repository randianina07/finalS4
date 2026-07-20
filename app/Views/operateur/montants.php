<?= $this->extend('layouts/operateur') ?>

<?= $this->section('content') ?>

<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-label">
            Total à envoyer aux autres opérateurs
        </div>
        <div class="stat-value">
            <?= number_format($total_externe, 0, ',', ' ') ?> Ar
        </div>
    </div>
</div>

<div class="page-card">
    <h2> Montants par opérateur</h2>

    <?php if (empty($montants_reseaux)): ?>

        <div class="empty-state">
            Aucun montant à reverser pour le moment.
        </div>

    <?php else: ?>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Opérateur</th>
                        <th>Montant à envoyer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($montants_reseaux as $m): ?>
                        <tr>
                            <td>
                                <?= esc($m['reseau']) ?>
                            </td>

                            <td>
                                <?= number_format($m['montant'], 0, ',', ' ') ?> Ar
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>