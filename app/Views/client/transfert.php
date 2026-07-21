<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

<div class="page-card">

    <h2>🔄 Faire un transfert</h2>

    <form method="post" action="/client/transfert">

        <div class="form-group">
            <label for="montant">Montant global à envoyer (Ar)</label>
            <input
                type="number"
                id="montant"
                name="montant"
                min="1"
                step="1"
                required
                placeholder="Ex : 50000"
            >

            <small>
                En cas d'envoi multiple, ce montant sera réparti équitablement entre tous les destinataires.
            </small>
        </div>

        <div class="form-group">
            <label>Destinataire(s)</label>
            <div id="destinataires-container">
                <div class="destinataire-row" style="display:flex; gap:10px; margin-bottom:10px;">
                    <input type="text" name="numero_destinataire[]" placeholder="Numéro de téléphone" required>
                    <button type="button" class="btn-delete remove-dest-btn" style="display:none;">✕</button>
                </div>
            </div>

            <button type="button" id="add-dest-btn" class="btn btn-submit" style="margin-top:10px;">+ Ajouter un destinataire</button>
        </div>

        <div id="frais-retrait-wrapper" class="form-group">
            <label>
                <input type="checkbox" name="retrait" value="1" id="retrait">Inclure les frais de retrait pour le destinataire
            </label>
        </div>

        <button type="submit" class="btn btn-submit">
            Confirmer le transfert
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('destinataires-container');
    const addBtn = document.getElementById('add-dest-btn');
    const checkboxWrapper = document.getElementById('frais-retrait-wrapper');
    const checkboxInput = document.getElementById('retrait');

    function toggleOptions() {
        const rows = container.querySelectorAll('.destinataire-row');
        rows.forEach((row) => {
            const deleteBtn = row.querySelector('.remove-dest-btn');
            deleteBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        });

        if (rows.length > 1) {
            checkboxWrapper.style.display = 'none';
            checkboxInput.checked = false;
        } else {
            checkboxWrapper.style.display = 'block';
        }
    }
    addBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.destinataire-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('input').value = '';
        container.appendChild(newRow);
        toggleOptions();
    });
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-dest-btn')) {

            e.target
                .closest('.destinataire-row')
                .remove();

            toggleOptions();
        }
    });
    toggleOptions();
});
</script>

<?= $this->endSection() ?>