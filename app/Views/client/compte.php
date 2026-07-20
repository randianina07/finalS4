<?= $this->extend('layouts/client') ?>

<?= $this->section('content') ?>

<h2>Mon compte</h2>


<div class="card">

<h3>
Solde disponible
</h3>

<h1>
<?= number_format($client['solde'],0,' ',' ') ?> Ar
</h1>

</div>


<?= $this->endSection() ?>