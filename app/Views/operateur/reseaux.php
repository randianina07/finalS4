<?= $this->extend('layouts/operateur') ?>

<?= $this->section('content') ?>

    <div class="page-card">
        <h2>🌐 Ajouter un réseau</h2>

        <form method="post" action="/operateur/reseaux/ajouter" class="inline-form">

            <div class="form-group">
                <label>Nom du réseau</label>
                <input type="text" name="nom" required>
            </div>

            <div class="form-group">
                <label>Commission transfert externe (%)</label>
                <input type="number"
                       name="commission_transfert"
                       min="0"
                       step="0.01"
                       value="0"
                       required>
            </div>

            <button type="submit" class="btn btn-submit">
                Ajouter
            </button>

        </form>
    </div>

    <div class="page-card">

        <h2>Réseaux enregistrés</h2>

        <?php if (empty($reseaux)): ?>

            <div class="empty-state">
                Aucun réseau configuré.
            </div>

        <?php else: ?>

            <div class="table-wrap">

                <table class="data-table">

                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Commission (%)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($reseaux as $reseau): ?>

                            <tr>

                                <td>
                                    <?= esc($reseau['nom']) ?>
                                </td>

                                <td>
                                    <?= esc($reseau['commission_transfert']) ?> %
                                </td>

                                <td>

                                    <a
                                        href="/operateur/reseaux/modifier/<?= $reseau['id'] ?>"
                                        class="btn-edit">
                                        Modifier
                                    </a>

                                    <a
                                        href="/operateur/reseaux/supprimer/<?= $reseau['id'] ?>"
                                        class="btn-delete"
                                        onclick="return confirm('Supprimer ce réseau ?');">
                                        Supprimer
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

<?= $this->endSection() ?>