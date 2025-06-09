<?php /** @var array $products */ ?>

<h2 class="text-center fw-bold my-4">Позначення товарів як акційні або популярні</h2>

<form method="post" action="/admin/updatemarks">
    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-light">
        <tr>
            <th>Товар</th>
            <th>Ціна</th>
            <th>Популярний</th>
            <th>Акція (зі знижкою)</th>
            <th>Нова ціна</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= number_format($product['price'], 2) ?> грн</td>
                <td>
                    <input type="checkbox" name="popular[<?= $product['id'] ?>]" <?= $product['is_popular'] ? 'checked' : '' ?>>
                </td>
                <td>
                    <input type="checkbox" name="discounted[<?= $product['id'] ?>]" <?= $product['is_discounted'] ? 'checked' : '' ?>>
                </td>
                <td>
                    <input type="number" step="0.01" name="new_price[<?= $product['id'] ?>]"
                           class="form-control" value="<?= $product['new_price'] ?? '' ?>" placeholder="грн">
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary px-4">Зберегти</button>
    </div>
</form>
