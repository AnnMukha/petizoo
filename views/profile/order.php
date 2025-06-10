<?php
/** @var array $order */
/** @var array $items */
?>

<div class="container my-5">
    <div class="mb-4">
        <h3 class="fw-bold text-teal">
            <i class="bi bi-bag-check me-2"></i>Деталі замовлення №<?= $order['id'] ?>
            від <?= date('d.m.Y H:i', strtotime($order['created_at'])) ?>
        </h3>
    </div>

    <div class="row g-4">
        <!-- Інформація про замовлення -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-teal"><i class="bi bi-person-vcard me-2"></i>Отримувач</h5>
                    <p class="mb-1"><strong>Ім’я:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                    <p class="mb-1"><strong>Телефон:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                    <p class="mb-1"><strong>Адреса:</strong> <?= htmlspecialchars($order['address']) ?></p>
                    <?php
                    $status = $order['status'];
                    $statusClass = match ($status) {
                        'Опрацьовується' => 'bg-success',
                        'Відправлено' => 'bg-primary',
                        'Доставлено' => 'bg-info',
                        'Скасовано' => 'bg-danger',
                        default => 'bg-secondary'
                    }; ?>
                    <p class="mb-1">
                        <strong>Статус:</strong>
                        <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($status) ?></span>
                    </p>
                    <p class="mb-0"><strong>Сума:</strong> <?= number_format($order['total_price'], 2) ?> грн</p>
                </div>
            </div>
        </div>

        <!-- Список товарів -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-teal"><i class="bi bi-box-seam me-2"></i>Товари</h5>

                    <?php foreach ($items as $item): ?>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <img src="/<?= ltrim($item['image'], '/') ?>" width="80" class="rounded me-3 shadow-sm"
                                 alt="">
                            <div class="flex-grow-1">
                                <div class="fw-bold"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="text-muted small">Ціна: <?= number_format($item['price'], 2) ?> грн</div>
                                <div class="text-muted small">Кількість: <?= $item['quantity'] ?></div>
                            </div>
                            <div class="fw-bold text-end"><?= number_format($item['price'] * $item['quantity'], 2) ?>
                                грн
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 border-top pt-3">
        <h5 class="text-teal mb-2"><i class="bi bi-tags"></i> Застосована знижка</h5>
        <p>На ваше замовлення була застосована <strong>персональна знижка 5%</strong> за реєстрацію користувача.</p>

        <?php if (!empty($order['original_price']) && $order['original_price'] > $order['total_price']): ?>
            <p>Повна сума без знижки:
                <strong><?= number_format($order['original_price'], 2) ?> грн</strong>
            </p>
            <p>Ваша економія склала:
                <strong><?= number_format($order['original_price'] - $order['total_price'], 2) ?> грн</strong>
            </p>
        <?php endif; ?>

        <p class="mb-0">Загальна сума зі знижкою:
            <strong><?= number_format($order['total_price'], 2) ?> грн</strong>
        </p>
    </div>
    <div class="mt-4">
        <a href="/profile/orders" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Назад до списку замовлень
        </a>
    </div>
</div>
<style>
    .text-teal {
        color: #20c997;
    }
</style>