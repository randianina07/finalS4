<?= $this->extend('layouts/operateur') ?>

<?= $this->section('content') ?>

    <div class="page-card">
        <h2>📐 Ajouter une tranche de barème</h2>

        <form method="post" action="/operateur/baremes/enregistrer" class="inline-form">
            <div class="form-group">
                <label>Type d'opération</label>
                <select name="type_operation_id" required>
                    <option value="1">Dépôt</option>
                    <option value="2">Retrait</option>
                    <option value="3">Transfert</option>
                </select>
            </div>
            <div class="form-group">
                <label>Montant min</label>
                <input type="number" name="montant_min" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Montant max</label>
                <input type="number" name="montant_max" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Frais</label>
                <input type="number" name="frais" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-submit">Ajouter</button>
        </form>
    </div>

    <div class="page-card">
        <h2>Barèmes existants</h2>

        <?php if (empty($baremes)): ?>

            <div class="empty-state">Aucun barème configuré.</div>

        <?php else: ?>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Type d'opération</th>
                            <th>Montant min</th>
                            <th>Montant max</th>
                            <th>Frais</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($baremes as $b): ?>
                            <tr>
                                <td><?= esc($b['nom_operation']) ?></td>
                                <td><?= number_format($b['montant_min'], 0, ',', ' ') ?> Ar</td>
                                <td><?= number_format($b['montant_max'], 0, ',', ' ') ?> Ar</td>
                                <td><?= number_format($b['frais'], 0, ',', ' ') ?> Ar</td>
                                <td>
                                    <a class="btn-delete" href="/operateur/baremes/supprimer/<?= $b['id'] ?>"
                                       onclick="return confirm('Supprimer cette tranche ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>

<?= $this->endSection() ?>
