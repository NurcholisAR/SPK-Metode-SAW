<?php
$total = 100;
foreach ($kriteria as $k) : ?>
<?= ($k['bbn'] * $total) ?>
<?php endforeach; ?>