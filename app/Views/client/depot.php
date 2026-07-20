<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <div class="page-card" style="max-width:480px;">
        <h2>💰 Effectuer un dépôt</h2>

        <form method="post" action="/client/depot">
            <div class="form-group">
                <label>Montant (Ar)</label>
                <input type="number" name="montant" min="1" step="1" required>
            </div>
            <button type="submit" class="btn btn-submit">Déposer</button>
        </form>
    </div>

<?= $this->endSection() ?>
