<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <div class="page-card">
        <h2>📜 Historique des mouvements</h2>

        <?php if (empty($mouvements)): ?>

            <div class="empty-state">Aucun mouvement pour le moment.</div>

        <?php else: ?>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Détail</th>
                            <th>Montant brut</th>
                            <th>Frais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mouvements as $m): ?>
                            <?php
                                $badges = [1 => ['Dépôt', 'depot'], 2 => ['Retrait', 'retrait'], 3 => ['Transfert', 'transfert']];
                                [$label, $class] = $badges[$m['type_operation_id']] ?? ['Autre', 'depot'];
                            ?>
                            <tr>
                                <td><?= esc(date('d/m/Y H:i', strtotime($m['date_creation']))) ?></td>
                                <td><span class="badge badge-<?= $class ?>"><?= $label ?></span></td>
                                <td>
                                    <?php if ($m['type_operation_id'] == 3): ?>
                                        <?= $m['num_source'] ? esc($m['num_source']) : '—' ?> &rarr; <?= $m['num_dest'] ? esc($m['num_dest']) : '—' ?>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($m['montant_brut'], 0, ',', ' ') ?> Ar</td>
                                <td><?= number_format($m['frais'], 0, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination-links">
                <?= $pager->links('default_full') ?>
            </div>

        <?php endif; ?>
    </div>

<?= $this->endSection() ?>
