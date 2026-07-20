<?= $this->extend('layouts/operateur') ?>

<?= $this->section('content') ?>

    <div class="page-card">
        <h2>📶 Ajouter un préfixe</h2>

        <form method="post" action="/operateur/prefixes/ajouter" class="inline-form">
            <div class="form-group">
                <label>Préfixe (ex: 034)</label>
                <input type="text" name="prefixe" maxlength="10" required>
            </div>
            <button type="submit" class="btn btn-submit">Ajouter</button>
        </form>
    </div>

    <div class="page-card">
        <h2>Préfixes autorisés</h2>

        <?php if (empty($prefixes)): ?>

            <div class="empty-state">Aucun préfixe configuré.</div>

        <?php else: ?>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Préfixe</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prefixes as $p): ?>
                            <tr>
                                <td><?= esc($p['prefixe']) ?></td>
                                <td>
                                    <a class="btn-delete" href="/operateur/prefixes/supprimer/<?= $p['id'] ?>"
                                       onclick="return confirm('Supprimer ce préfixe ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>

<?= $this->endSection() ?>
