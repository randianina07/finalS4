<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <div class="page-card" style="max-width:480px;">
        <h2>🔄 Faire un transfert</h2>

        <form method="post" action="/client/transfert">
            <div class="form-group">
                <label>Numéro destinataire</label>
                <input type="text" name="numero_destinataire" required>
            </div>
            <div class="form-group">
                <label>Montant (Ar)</label>
                <input type="number" name="montant" min="1" step="1" required>
            </div>
            <button type="submit" class="btn btn-submit">Transférer</button>
        </form>
    </div>

<?= $this->endSection() ?>
