<?php /** @var int $totalProducts */ ?>
<?php /** @var int $totalOrders */ ?>
<?php /** @var int $discountedProducts */ ?>
<?php /** @var int $totalUsers */ ?>
<?php /** @var array $orderStatusCounts */ ?>
<?php /** @var int $popularProducts */ ?>

<div class="container my-5">
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-speedometer2 text-primary display-5 me-3"></i>
        <h2 class="m-0 text-dark fw-bold">Панель адміністратора</h2>
    </div>

    <!-- Статистика -->
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-5 text-center">
        <div class="col">
            <div class="card shadow-sm border-start border-primary border-4 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Товарів</h6>
                    <h3 class="fw-bold text-primary"><?= $totalProducts ?></h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm border-start border-success border-4 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Замовлень</h6>
                    <h3 class="fw-bold text-success"><?= $totalOrders ?></h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm border-start border-warning border-4 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Акційних товарів</h6>
                    <h3 class="fw-bold text-warning"><?= $discountedProducts ?></h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm border-start border-danger border-4 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Користувачів</h6>
                    <h3 class="fw-bold text-danger"><?= $totalUsers ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Дії -->
    <div class="d-flex justify-content-center gap-4 flex-wrap mb-5">
        <a href="/admin/products" class="btn btn-outline-primary btn-lg d-flex align-items-center gap-2 px-4">
            <i class="bi bi-box-seam"></i> Керування товарами
        </a>
        <a href="/admin/orders" class="btn btn-outline-success btn-lg d-flex align-items-center gap-2 px-4">
            <i class="bi bi-receipt-cutoff"></i> Керування замовленнями
        </a>
        <a href="/admin/markproducts" class="btn btn-outline-warning btn-lg d-flex align-items-center gap-2 px-4">
            <i class="bi bi-tags"></i> Акції та хіти
        </a>
        <a href="/" class="btn btn-outline-secondary btn-lg d-flex align-items-center gap-2 px-4">
            <i class="bi bi-arrow-left"></i> Повернутись на сайт
        </a>
    </div>

    <!-- Діаграми -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">🔢 Співвідношення товарів</h5>
                    <canvas id="productChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">📊 Замовлення за статусом</h5>
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('productChart').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Звичайні', 'Акційні', 'Хіти'],
            datasets: [{
                data: [
                    <?= $totalProducts - $discountedProducts - $popularProducts ?>,
                    <?= $discountedProducts ?>,
                    <?= $popularProducts ?>
                ],
                backgroundColor: ['#20c997', '#ffc107', '#ff6384'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    const ctx2 = document.getElementById('orderChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Опрацьовується', 'Відправлено', 'Доставлено', 'Скасовано'],
            datasets: [{
                label: 'К-сть замовлень',
                data: [
                    <?= $orderStatusCounts['Опрацьовується'] ?? 0 ?>,
                    <?= $orderStatusCounts['Відправлено'] ?? 0 ?>,
                    <?= $orderStatusCounts['Доставлено'] ?? 0 ?>,
                    <?= $orderStatusCounts['Скасовано'] ?? 0 ?>
                ],
                backgroundColor: ['#0dcaf0', '#198754', '#0d6efd', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

