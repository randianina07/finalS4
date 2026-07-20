<?= $this->extend('layouts/operateur') ?>

<?= $this->section('content') ?>

    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label">Total des gains</div>
            <div class="stat-value"><?= number_format($total_general, 0, ',', ' ') ?> Ar</div>
        </div>
    </div>

    <div class="page-card">
        <h2>📊 Détail par type d'opération</h2>

        <?php if (empty($gains)): ?>

            <div class="empty-state">Aucune donnée de gains pour le moment.</div>

        <?php else: ?>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Type d'opération</th>
                            <th>Nombre d'opérations</th>
                            <th>Total des frais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gains as $g): ?>
                            <tr>
                                <td><?= esc($g['nom']) ?></td>
                                <td><?= esc($g['nb_operations']) ?></td>
                                <td><?= number_format($g['total_frais'], 0, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>

    <div class="page-card">
        <h2>Gains par réseau</h2>
        <?php if (empty($gains)): ?>

            <div class="empty-state">Aucune donnée de gains pour le moment.</div>

        <?php else: ?>

            <div class="table-wrap">

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Réseau</th>
                            <th>Gain total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gainsParReseau as $g): ?>
                            <tr>
                                <td><?= esc($g['reseau']) ?></td>
                                <td><?= number_format($g['gain'], 0, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

<?= $this->endSection() ?>
