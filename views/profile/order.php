<?php
/** @var array $order */
/** @var array $items */
?>
<div class="container my-5">
    <h2 class="mb-4 text-teal">
        <i class="bi bi-receipt-cutoff me-2"></i>
        Деталі замовлення №<?= $order['id'] ?> від <?= date('d.m.Y H:i', strtotime($order['created_at'])) ?>
    </h2>

    <div class="row g-4">
        <!-- Лівий блок з інформацією -->
        <div class="col-md-5">
            <div class="bg-light border rounded p-4 shadow-sm">
                <h5 class="mb-3 text-teal"><i class="bi bi-info-circle me-2"></i>Інформація</h5>
                <ul class="list-unstyled">
                    <li><strong>Ім’я отримувача:</strong> <?= htmlspecialchars($order['full_name']) ?></li>
                    <li><strong>Телефон:</strong> <?= htmlspecialchars($order['phone']) ?></li>
                    <li><strong>Адреса доставки:</strong> <?= htmlspecialchars($order['address']) ?></li>
                    <li><strong>Статус:</strong> <span class="badge bg-success">Опрацьовується</span></li>
                    <li><strong>Сума замовлення:</strong> <?= number_format($order['total_price'], 2) ?> грн</li>
                </ul>
            </div>
        </div>

        <!-- Правий блок зі списком товарів -->
        <div class="col-md-7">
            <div class="bg-white border rounded p-4 shadow-sm">
                <h5 class="mb-3 text-teal"><i class="bi bi-box-seam me-2"></i>Товари</h5>
                <?php foreach ($items as $item): ?>
                    <div class="d-flex align-items-center border-bottom py-3 gap-3">
                        <img src="/<?= ltrim($item['image'], '/') ?>" width="80" class="rounded shadow-sm" alt="">
                        <div class="flex-grow-1">
                            <div class="fw-bold"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="small text-muted">Ціна: <?= number_format($item['price'], 2) ?> грн</div>
                            <div class="small text-muted">Кількість: <?= $item['quantity'] ?></div>
                        </div>
                        <div class="text-end fw-bold"><?= number_format($item['price'] * $item['quantity'], 2) ?> грн</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="/profile/orders" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Назад до списку замовлень
        </a>
    </div>
</div>
