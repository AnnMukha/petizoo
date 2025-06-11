<?php
/** @var array $subcategories */
/** @var array $product */

$product = $product ?? [];
?>

<div class="row w-100">
    <div class="col-md-6">
        <h2 class="mb-4 fw-bold text-center">Додавання товару</h2>
        <form method="post" enctype="multipart/form-data" class="w-100" id="productForm">
            <div class="mb-3">
                <label class="form-label">Назва</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name'] ?? '') ?>" oninput="updatePreview()">
            </div>

            <div class="mb-3">
                <label class="form-label">Опис</label>
                <textarea name="description" class="form-control" rows="6" oninput="updatePreview()" placeholder="Введіть опис. Можна використовувати абзаци."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Ціна</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?? 0 ?>" oninput="updatePreview()">
            </div>

            <div class="mb-3">
                <label class="form-label">Кількість</label>
                <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?? 0 ?>" oninput="updatePreview()">
            </div>

            <div class="mb-3">
                <label class="form-label">Підкатегорія</label>
                <select name="subcategory_id" id="subcategory_id" class="form-select" onchange="updatePreview()">
                    <option value="" disabled <?= empty($product['subcategory_id']) ? 'selected' : '' ?>>Оберіть підкатегорію</option>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <option value="<?= $subcategory['id'] ?>" <?= ($product['subcategory_id'] ?? '') == $subcategory['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($subcategory['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Для кого</label>
                <select name="is_for" class="form-select" onchange="updatePreview()">
                    <option value="cat" <?= ($product['is_for'] ?? '') === 'cat' ? 'selected' : '' ?>>Котам</option>
                    <option value="dog" <?= ($product['is_for'] ?? '') === 'dog' ? 'selected' : '' ?>>Собакам</option>
                    <option value="both" <?= ($product['is_for'] ?? '') === 'both' ? 'selected' : '' ?>>Котам і собакам</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Фото</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Додати товар</button>
                <a href="/admin/products" class="btn btn-secondary">Назад</a>
            </div>
        </form>
    </div>

    <div class="col-md-6 border-start ps-4">
        <h4 class="fw-bold mb-3 text-center">Попередній перегляд</h4>
        <div class="card">
            <div class="card-body">
                <p id="previewImage" class="text-muted text-center">Фото ще не додано</p>
                <h5 class="card-title" id="previewName"><?= htmlspecialchars($product['name'] ?? '') ?></h5>
                <p class="card-text" id="previewDesc" style="white-space: pre-wrap;">
                    <?= htmlspecialchars($product['description'] ?? '') ?>
                </p>
                <p><strong>Ціна:</strong> <span id="previewPrice"><?= number_format($product['price'] ?? 0, 2) ?></span> грн</p>
                <p><strong>Кількість:</strong> <span id="previewStock"><?= $product['stock'] ?? 0 ?></span></p>
                <p><strong>Для кого:</strong> <span id="previewFor">
                    <?= ($product['is_for'] ?? '') === 'cat' ? 'Котам' :
                        (($product['is_for'] ?? '') === 'dog' ? 'Собакам' :
                            (($product['is_for'] ?? '') === 'both' ? 'Котам і собакам' : '')) ?>
                </span></p>
                <p><strong>Підкатегорія ID:</strong> <span id="previewSubcategory"><?= htmlspecialchars($product['subcategory_id'] ?? '') ?></span></p>
            </div>
        </div>
    </div>
</div>
<script>
    function updatePreview() {
        const form = document.forms['productForm'];

        document.getElementById('previewName').textContent = form.name.value;
        document.getElementById('previewDesc').textContent = form.description.value;
        document.getElementById('previewPrice').textContent = parseFloat(form.price.value || 0).toFixed(2);
        document.getElementById('previewStock').textContent = form.stock.value || 0;

        const isForText = {
            cat: "Котам",
            dog: "Собакам",
            both: "Котам і собакам"
        };
        document.getElementById('previewFor').textContent = isForText[form.is_for.value] || '';

        document.getElementById('previewSubcategory').textContent = form.subcategory_id.value || '';
    }
</script>
