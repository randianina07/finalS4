<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <h2>Faire un transfert</h2>

    <form method="post" action="/client/transfert">
        <label>Numéro destinataire</label>
        <input type="text" name="numero_destinataire" required>
        <label>Montant</label>
        <input type="number" name="montant" required>
        <button class="btn btn-submit">Transférer</button>
    </form>

<?= $this->endSection() ?>