<?php /** @var array $order */ ?>
<?php /** @var array $items */ ?>

<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="text-primary fw-bold">
            <i class="bi bi-clipboard-check me-2"></i>
            Замовлення #<?= $order['id'] ?>
        </h2>
        <p class="text-muted">Оформлене <?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Інформація про клієнта</h5>
                    <p><strong>ПІБ:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                    <p><strong>Телефон:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                    <p><strong>Адреса:</strong> <?= htmlspecialchars($order['address']) ?></p>
                    <p><strong>Статус:</strong> <?= htmlspecialchars($order['status']) ?></p>
                    <p><strong>Сума:</strong> <?= number_format($order['total_price'], 2) ?> грн</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Знижка</h5>
                    <?php if (!empty($order['original_price']) && $order['original_price'] > $order['total_price']): ?>
                        <p>Початкова сума: <strong><?= number_format($order['original_price'], 2) ?> грн</strong></p>
                        <p>Сума після знижки: <strong><?= number_format($order['total_price'], 2) ?> грн</strong></p>
                        <p class="text-success">Економія: <strong><?= number_format($order['original_price'] - $order['total_price'], 2) ?> грн</strong></p>
                    <?php else: ?>
                        <p>Знижка не застосовувалась.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Список товарів</h5>
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
            <tr>
                <th>Фото</th>
                <th>Назва</th>
                <th>Ціна</th>
                <th>Кількість</th>
                <th>Разом</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><img src="/<?= ltrim($item['image'], '/') ?>" width="60" class="rounded shadow-sm"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price'], 2) ?> грн</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><strong><?= number_format($item['price'] * $item['quantity'], 2) ?> грн</strong></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="/admin/orders" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Назад до списку замовлень
        </a>
    </div>
</div>
