<?php
/** @var array $orders */
?>

<link rel="stylesheet" href="/css/cart.css">

<div class="order-title-wrapper text-center mb-4">
    <h3 class="order-title"><i class="bi bi-list-check me-2"></i>Мої замовлення</h3>
    <p class="order-subtitle">Слідкуйте за статусом та деталями ваших покупок</p>
</div>

<?php if (empty($orders)): ?>
    <div class="alert alert-info text-center shadow-sm rounded-4">
        Ви ще не робили жодного замовлення.
    </div>
<?php else: ?>
    <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-center">
            <tr>
                <th style="width: 8%">ID</th>
                <th style="width: 25%">Дата</th>
                <th style="width: 20%">Сума</th>
                <th style="width: 20%">Статус</th>
                <th style="width: 20%">Дії</th>
            </tr>
            </thead>
            <tbody class="text-center">
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td class="fw-bold">#<?= $order['id'] ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                    <td class="fw-semibold"><?= number_format($order['total_price'], 2) ?> грн</td>
                    <td>
                        <?php
                        $statusClass = match ($order['status']) {
                            'Опрацьовується' => 'bg-success',
                            'Відправлено' => 'bg-primary',
                            'Доставлено' => 'bg-info',
                            'Скасовано' => 'bg-danger',
                            default => 'bg-secondary'
                        }; ?>
                        <span class="badge <?= $statusClass ?> px-3 py-2 rounded-pill shadow-sm"> <?= htmlspecialchars($order['status']) ?></span>
                    </td>

                    <td>
                        <a href="/profile/order/<?= $order['id'] ?>"
                           class="btn btn-outline-primary btn-sm px-3 shadow-sm rounded-pill">
                            <i class="bi bi-eye"></i> Переглянути
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
</div>
<style>
    .order-title-wrapper {
        background: #f3fff3;
        padding: 1.2rem 1rem;
        border-radius: 1rem;
        border: 2px dashed #28a745;
        box-shadow: 0 0 6px rgba(40, 167, 69, 0.1);
    }

    .order-title {
        font-size: 1.6rem;
        font-weight: 600;
        color: #28a745;
        font-family: 'Segoe UI', sans-serif;
        margin-bottom: 0.2rem;
    }

    .order-subtitle {
        font-size: 0.95rem;
        color: #5c755d;
        font-style: italic;
    }
</style>


