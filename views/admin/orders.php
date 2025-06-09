<?php /** @var array $orders */ ?>
<div class="container my-5">
    <h2 class="mb-4">Список усіх замовлень</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">Замовлень поки що немає.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Користувач</th>
                    <th>Дата</th>
                    <th>Сума</th>
                    <th>Кількість товарів</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['login']) ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                        <td><strong><?= number_format($order['total_price'], 2) ?> грн</strong></td>
                        <td><?= $order['items_count'] ?></td>
                        <td><?= $order['status'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>