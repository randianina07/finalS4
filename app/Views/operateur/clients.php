<?= $this->extend('layouts/operateur') ?>

<?= $this->section('content') ?>

    <div class="page-card">
        <h2>👥 Liste des clients</h2>

        <?php if (empty($clients)): ?>

            <div class="empty-state">Aucun client enregistré.</div>

        <?php else: ?>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Numéro de téléphone</th>
                            <th>Solde</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $c): ?>
                            <tr>
                                <td><?= esc($c['id']) ?></td>
                                <td><?= esc($c['numero_telephone']) ?></td>
                                <td><?= number_format($c['solde'], 0, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination-links">
                <?= $pager->links() ?>
            </div>

        <?php endif; ?>
    </div>

<?= $this->endSection() ?>
