<?php
/** @var array $orders */
?>

<div class="container my-5">
    <h2 class="mb-4">Мої замовлення</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">Ви ще не робили жодного замовлення.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Дата</th>
                    <th>Сума</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                        <td><strong><?= number_format($order['total_price'], 2) ?> грн</strong></td>
                        <td>
                            <span class="badge bg-success">Опрацьовується</span>
                        </td>
                        <td>
                            <a href="/profile/order/<?= $order['id'] ?>" class="btn btn-outline-primary btn-sm">
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