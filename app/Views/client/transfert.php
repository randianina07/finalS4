<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

    <div class="page-card" style="max-width:550px; margin: 0 auto;">
        <h2>🔄 Faire un transfert</h2>

        <form method="post" action="/client/transfert">
            
            <div id="destinataires-container">
                <label class="form-label">Destinataire(s) et Montant(s)</label>
                
                <div class="row g-2 mb-2 destinataire-row">
                    <div class="col-7">
                        <input type="text" name="numero_destinataire[]" class="form-control" placeholder="Numéro" required>
                    </div>
                    <div class="col-4">
                        <input type="number" name="montant[]" min="1" step="1" class="form-control" placeholder="Montant (Ar)" required>
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-dest-btn" style="display:none;">&times;</button>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <button type="button" id="add-dest-btn" class="btn btn-outline-secondary btn-sm">+ Ajouter un destinataire</button>
            </div>

            <div id="frais-retrait-wrapper" class="form-check mb-4">
                <input type="checkbox" name="retrait" value="1" id="retrait" class="form-check-input">
                <label class="form-check-label" for="retrait">
                    Inclure le frais de retrait pour le destinataire
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Transférer</button>
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
                
                rows.forEach((row, index) => {
                    const deleteBtn = row.querySelector('.remove-dest-btn');
                    deleteBtn.style.display = rows.length > 1 ? 'block' : 'none';
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
                
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                
                container.appendChild(newRow);
                toggleOptions();
            });

            // Supprimer une ligne via la délégation d'événements
            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-dest-btn')) {
                    e.target.closest('.destinataire-row').remove();
                    toggleOptions();
                }
            });
        });
    </script>

<?= $this->endSection() ?>