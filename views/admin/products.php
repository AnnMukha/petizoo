<?php /** @var array $products */ ?>
<?php if (!isset($products)) $products = []; ?>

<h2 class="mb-4 fw-bold text-center">Керування товарами</h2>

<div class="text-end mb-3">
    <a href="/admin/addproduct" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i> Додати товар
    </a>
</div>

<table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
    <tr>
        <th>№</th> <!-- Замість ID -->
        <th>Назва</th>
        <th>Ціна</th>
        <th>Категорія</th>
        <th>Кількість</th>
        <th>Дії</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($products)): ?>
        <?php $i = 1; ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $i++ ?></td> <!-- Порядковий номер -->
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= number_format($product['price'], 2) ?> грн</td>
                <td><?= \models\Subcategory::getById($product['subcategory_id'])['name'] ?? '—' ?></td>
                <td><?= $product['stock'] ?></td>
                <td>
                    <a href="/admin/editproduct/<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="/admin/deleteproduct/<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Ви впевнені, що хочете видалити цей товар?');">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6" class="text-center text-muted">Немає жодного товару 🐾</td></tr>
    <?php endif; ?>
    </tbody>
</table>