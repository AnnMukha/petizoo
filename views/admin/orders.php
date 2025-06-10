<?php /** @var array $orders */ ?>

<div class="container my-5">
    <div class="admin-title-wrapper text-center mb-4">
        <h2 class="text-success fw-bold">📦 Усі замовлення</h2>
        <p class="text-muted">Адміністративне керування замовленнями</p>
    </div>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Користувач</th>
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
                    <td><?= htmlspecialchars($order['full_name']) ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                    <td><strong><?= number_format($order['total_price'], 2) ?> грн</strong></td>
                    <td>
                        <form class="status-form d-flex gap-2 justify-content-center" data-id="<?= $order['id'] ?>">
                            <select name="status" class="form-select form-select-sm status-select" style="width: auto;">
                                <?php foreach (['Опрацьовується', 'Відправлено', 'Доставлено', 'Скасовано'] as $status): ?>
                                    <option value="<?= $status ?>" <?= $order['status'] === $status ? 'selected' : '' ?>>
                                        <?= $status ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-sm btn-outline-success">Зберегти</button>
                        </form>
                        <div class="status-feedback text-success small text-center mt-1" style="display:none;"></div>
                    </td>
                    <td>
                        <a href="/admin/orders/vieworder/<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Переглянути
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.querySelectorAll('.status-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const orderId = this.dataset.id;
            const status = this.querySelector('.status-select').value;
            const feedback = this.nextElementSibling;

            fetch('/admin/orders/updatestatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `order_id=${orderId}&status=${encodeURIComponent(status)}`
            })
                .then(res => res.ok ? res.text() : Promise.reject(res.status))
                .then(() => {
                    feedback.textContent = '✔ Статус оновлено!';
                    feedback.style.display = 'block';
                    feedback.style.color = 'green';

                    setTimeout(() => {
                        feedback.style.display = 'none';
                    }, 3000);
                })
                .catch(() => {
                    feedback.textContent = '❌ Помилка оновлення';
                    feedback.style.display = 'block';
                    feedback.style.color = 'red';
                });
        });
    });
</script>
