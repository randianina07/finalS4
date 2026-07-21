<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <div class="page-card" style="max-width:550px; margin: 0 auto;">
        <h2>🔄 Faire un transfert</h2>

        <!-- Alertes de retour -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger mb-3">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success mb-3">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/client/transfert">
            
            <!-- Champ Montant Unique -->
            <div class="mb-3">
                <label for="montant" class="form-label font-weight-bold">Montant global à envoyer (Ar)</label>
                <input type="number" name="montant" id="montant" min="1" step="1" class="form-control" placeholder="Ex: 50000" required>
                <small class="text-muted d-block mt-1">
                    En cas de destinataires multiples, ce montant sera divisé équitablement entre eux.
                </small>
            </div>

            <!-- Liste dynamique des destinataires -->
            <div id="destinataires-container" class="mb-2">
                <label class="form-label font-weight-bold">Destinataire(s)</label>
                
                <div class="row g-2 mb-2 destinataire-row">
                    <div class="col-10">
                        <input type="text" name="numero_destinataire[]" class="form-control" placeholder="Numéro de téléphone" required>
                    </div>
                    <div class="col-2 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-dest-btn" style="display:none;">&times;</button>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <button type="button" id="add-dest-btn" class="btn btn-outline-secondary btn-sm">+ Ajouter un destinataire</button>
            </div>

            <!-- Option Frais de retrait (Envoi unique seulement) -->
            <div id="frais-retrait-wrapper" class="form-check mb-4">
                <input type="checkbox" name="retrait" value="1" id="retrait" class="form-check-input">
                <label class="form-check-label" for="retrait">
                    Inclure le frais de retrait pour le destinataire
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Confirmer le transfert</button>
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
                    deleteBtn.style.display = rows.length > 1 ? 'block' : 'none';
                });

                // Si envoi multiple, on masque l'option frais de retrait
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
                    e.target.closest('.destinataire-row').remove();
                    toggleOptions();
                }
            });
        });
    </script>

<?= $this->endSection() ?>