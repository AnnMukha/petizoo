<?php
/** @var int|null $order_id */
/** @var string|null $info_message */
?>

<link rel="stylesheet" href="/css/cart.css">

<div class="container my-5 p-4 rounded-4 shadow-sm text-center bg-light" style="max-width: 700px;">
    <div class="mb-4">
        <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #28a745;"></i>
        <h2 class="fw-bold text-success mt-3">Замовлення оформлено!</h2>
    </div>

    <p class="fs-5 mb-2">
        Номер вашого замовлення:
        <strong class="text-dark">#<?= htmlspecialchars($order_id ?? '—') ?></strong>
    </p>

    <p class="text-muted"><?= htmlspecialchars($info_message ?? '') ?></p>

    <a href="/" class="btn btn-outline-primary mt-3 px-4 py-2 rounded-pill">
        <i class="bi bi-arrow-left"></i> Повернутись на головну
    </a>
</div>