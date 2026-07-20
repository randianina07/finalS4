<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <h2>Effectuer un dépôt</h2>

    <form method="post" action="/client/depot">
        <div class="form-group">
            <label>Montant</label>
            <input type="number" name="montant" required>
        </div>
        <button class="btn btn-submit">Déposer</button>
    </form>

<?= $this->endSection() ?>