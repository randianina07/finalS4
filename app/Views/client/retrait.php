<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <h2>Effectuer un retrait</h2>

    <form method="post" action="/client/retrait">
        <label>Montant</label>
        <input type="number" name="montant" required>
        <button class="btn btn-submit">Retirer</button>
    </form>

<?= $this->endSection() ?>