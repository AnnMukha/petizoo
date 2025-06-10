<?php
/** @var array $product */
/** @var array $subcategories */

if (!isset($product)) {
    echo '<div class="alert alert-danger">Помилка: продукт не передано у view</div>';
    return;
}
?>

<div class="row w-100">
    <!-- Редагування -->
    <div class="col-md-6">
        <h2 class="mb-4 fw-bold text-center">Редагування товару</h2>
        <form method="post" enctype="multipart/form-data" class="w-100">
            <div class="mb-3">
                <label class="form-label">Назва</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Опис</label>
                <textarea name="description" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Ціна</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Кількість</label>
                <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Підкатегорія</label>
                <select name="subcategory_id" class="form-select">
                    <?php foreach ($subcategories as $subcategory): ?>
                        <option value="<?= $subcategory['id'] ?>" <?= $subcategory['id'] == $product['subcategory_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($subcategory['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Для кого</label>
                <select name="is_for" class="form-select">
                    <option value="cat" <?= $product['is_for'] === 'cat' ? 'selected' : '' ?>>Котам</option>
                    <option value="dog" <?= $product['is_for'] === 'dog' ? 'selected' : '' ?>>Собакам</option>
                    <option value="both" <?= $product['is_for'] === 'both' ? 'selected' : '' ?>>Котам і собакам</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Фото (якщо хочеш змінити)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                <a href="/admin/products" class="btn btn-secondary">Назад</a>
            </div>
        </form>
    </div>

    <!-- Попередній перегляд -->
    <!-- Попередній перегляд -->
    <div class="col-md-6 border-start ps-4">
        <h4 class="fw-bold mb-3 text-center">Перегляд товару</h4>
        <div class="card">
            <?php if (!empty($product['image'])): ?>
                <img src="/<?= ltrim($product['image'], '/') ?>"
                     class="card-img-top preview-img"
                     alt="Фото товару">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                <p><strong>Ціна:</strong> <?= number_format($product['price'], 2) ?> грн</p>
                <p><strong>Кількість:</strong> <?= $product['stock'] ?></p>
                <p><strong>Для кого:</strong>
                    <?= $product['is_for'] === 'cat' ? 'Котам' : ($product['is_for'] === 'dog' ? 'Собакам' : 'Котам і собакам') ?>
                </p>
                <p><strong>Підкатегорія ID:</strong> <?= $product['subcategory_id'] ?></p>
            </div>
        </div>
    </div>
</div>
<style>
    .preview-img {
        max-height: 350px;
        width: auto;
        object-fit: contain;
        margin: 0 auto;
        padding: 15px;
    }
</style>