<?php /** @var array $products */ ?>
<?php /** @var array $categories */ ?>
<?php /** @var array $subcategories */ ?>
<?php /** @var string $animal */ ?>
<?php /** @var string $category */ ?>
<?php /** @var string $subcategory */ ?>

<div class="container my-5">
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-grid-fill text-primary display-5 me-3"></i>
        <h2 class="m-0 text-dark fw-bold">Каталог товарів</h2>
    </div>

    <div class="row g-4">
        <!-- Сайдбар фільтр -->
        <div class="col-md-3">
            <form method="get" class="bg-white shadow-sm rounded-4 p-4 border border-primary-subtle">
                <h5 class="fw-bold mb-3 text-primary">🔍 Фільтри</h5>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Для кого:</label>
                    <select name="animal" class="form-select">
                        <option value="all" <?= $animal === 'all' ? 'selected' : '' ?>>Усі</option>
                        <option value="cat" <?= $animal === 'cat' ? 'selected' : '' ?>>Котам</option>
                        <option value="dog" <?= $animal === 'dog' ? 'selected' : '' ?>>Собакам</option>
                        <option value="both" <?= $animal === 'both' ? 'selected' : '' ?>>Котам і собакам</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Категорія:</label>
                    <select name="category" id="categorySelect" class="form-select">
                        <option value="all" <?= $category === 'all' ? 'selected' : '' ?>>Усі</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Підкатегорія:</label>
                    <select name="subcategory" id="subcategorySelect" class="form-select">
                        <option value="all" <?= $subcategory === 'all' ? 'selected' : '' ?>>Усі</option>
                        <?php foreach ($subcategories as $sub): ?>
                            <option value="<?= $sub['id'] ?>" data-category="<?= $sub['category_id'] ?>" <?= $subcategory == $sub['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sub['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-filter me-1"></i> Застосувати
                </button>
            </form>
        </div>

        <!-- Товари -->
        <div class="col-md-9">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col">
                            <div class="card product-card h-100 shadow-sm rounded-4 position-relative">
                                <?php if ($product['is_discounted']): ?>
                                    <span class="position-absolute top-0 start-0 m-2 px-3 py-1 fw-bold shadow"
                                          style="background: linear-gradient(135deg, #ff3e3e, #b30000); color: #fff; font-size: 0.85rem; border-radius: 6px 0 6px 0; border: 1px solid #aa0000;">ЗНИЖКА!</span>
                                <?php endif; ?>
                                <?php if ($product['is_popular']): ?>
                                    <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark px-3 py-2 shadow fw-bold"
                                          style="font-size: 0.9rem; border-radius: 8px; border: 1px solid #ffc107;">🔥 ХІТ</span>
                                <?php endif; ?>
                                <a href="/products/view/<?= $product['id'] ?>" class="text-decoration-none text-dark">
                                    <div class="product-img-wrapper bg-light d-flex align-items-center justify-content-center p-4">
                                        <img src="/<?= ltrim($product['image'], '/') ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
                                    </div>
                                    <div class="card-body text-center px-3 py-2">
                                        <h5 class="card-title fw-bold text-dark"><?= htmlspecialchars($product['name']) ?></h5>
                                        <p class="card-text small text-muted"><?= htmlspecialchars($product['description']) ?></p>
                                    </div>
                                </a>
                                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center px-3 pb-3">
                                    <div class="d-flex flex-column align-items-start">
                                        <?php if ($product['is_discounted'] && $product['new_price'] !== null): ?>
                                            <small class="text-muted text-decoration-line-through"><?= number_format($product['price'], 2) ?> грн</small>
                                            <span class="text-danger fw-bold fs-5"><?= number_format($product['new_price'], 2) ?> грн</span>
                                        <?php else: ?>
                                            <span class="fw-bold text-teal fs-5"><?= number_format($product['price'], 2) ?> грн</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <a href="/cart/ajaxadd/<?= $product['id'] ?>"
                                           class="btn btn-outline-teal btn-icon shadow-sm btn-add-to-cart"
                                           data-id="<?= $product['id'] ?>" title="Додати до кошика">
                                            <i class="bi bi-cart-plus fs-5"></i>
                                        </a>
                                        <?php if (\models\Users::IsUserLogged()): ?>
                                            <?php
                                            $isFavorite = \core\Core::get()->db->select('favorites', '*', [
                                                'user_id' => $_SESSION['user']['id'],
                                                'product_id' => $product['id']
                                            ]);
                                            ?>
                                            <button class="btn btn-outline-danger btn-icon shadow-sm toggle-favorite"
                                                    data-product-id="<?= $product['id'] ?>" title="У вибране">
                                                <i class="bi <?= $isFavorite ? 'bi-heart-fill text-danger' : 'bi-heart' ?> fs-5"></i>
                                            </button>
                                        <?php else: ?>
                                            <div class="position-relative">
                                                <button class="btn btn-outline-danger btn-icon shadow-sm btn-disabled-tooltip"
                                                        data-tooltip="Увійдіть до акаунта, щоб додати в улюблене">
                                                    <i class="bi bi-heart fs-5"></i>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center fw-semibold text-muted">Немає товарів за вибраними фільтрами 😿</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('categorySelect');
        const subcategorySelect = document.getElementById('subcategorySelect');

        function filterSubcategories() {
            const selectedCategory = categorySelect.value;
            Array.from(subcategorySelect.options).forEach(option => {
                const optionCategory = option.dataset.category;
                if (!optionCategory || selectedCategory === 'all') {
                    option.hidden = false;
                } else {
                    option.hidden = optionCategory !== selectedCategory;
                }
            });
            if (subcategorySelect.selectedOptions.length > 0 &&
                subcategorySelect.selectedOptions[0].hidden) {
                subcategorySelect.value = 'all';
            }
        }

        categorySelect.addEventListener('change', filterSubcategories);
        filterSubcategories();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-add-to-cart');
        buttons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.href;

                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            let badge = document.getElementById('cart-badge');
                            if (!badge) {
                                const cartBtn = document.querySelector('a[href="/cart/index"]');
                                if (cartBtn) {
                                    badge = document.createElement('span');
                                    badge.id = 'cart-badge';
                                    badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                                    cartBtn.appendChild(badge);
                                }
                            }
                            if (badge) {
                                badge.textContent = data.count;
                            }
                        }
                    });
            });
        });
    });
    document.querySelectorAll('.toggle-favorite').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');

            fetch('/products/favoriteajax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'product_id=' + productId
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'added') {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill', 'text-danger');
                    } else if (data.status === 'removed') {
                        icon.classList.remove('bi-heart-fill', 'text-danger');
                        icon.classList.add('bi-heart');
                    }
                });
        });
    });
</script>
<style>
    .btn-outline-teal {
        color: #20c997;
        border-color: #20c997;
    }
    .btn-outline-teal:hover {
        background-color: #20c997;
        color: white;
    }
    .text-teal {
        color: #20c997;
    }

    .product-card {
        background-color: #fcfcfc;
        border: 1px solid #e6e6e6;
        transition: all 0.25s ease;
        border-radius: 1.5rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        cursor: pointer;
        margin-bottom: 10px;
    }

    .product-card:hover {
        background-color: #f9fdfa;
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(32, 201, 151, 0.1);
        border: 2px solid #20c997;
    }

    .product-img-wrapper {
        height: 220px;
        overflow: hidden;
        border-bottom: 1px solid #f0f0f0;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        background-color: #fefefe;
        transition: background-color 0.3s ease;
    }

    .product-img-wrapper:hover {
        background-color: #e0f8f3;
    }

    .product-img-wrapper img {
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .btn-icon {
        width: 42px;
        height: 42px;
        padding: 6px;
        font-size: 1.25rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    .btn-icon {
        width: 42px;
        height: 42px;
        padding: 6px;
        font-size: 1.25rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-icon i.bi-heart-fill {
        color: red;
    }
    .btn-disabled-tooltip {
        position: relative;
        opacity: 1;
        cursor: not-allowed;
        border: 1px solid #dc3545 !important; /* Яскрава рамка */
        background-color: transparent;
        pointer-events: auto;
    }

    .btn-disabled-tooltip::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: -36px; /* Відступ вниз */
        right: -10px;  /* Відступ справа */
        background-color: #f8d7da;
        color: #721c24;
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 5px;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        opacity: 0;
        transform: translateY(5px);
        transition: all 0.2s ease, transform 0.2s ease;
        z-index: 9999;
    }

    .btn-disabled-tooltip:hover::after {
        opacity: 1;
        transform: translateY(0);
    }
    .card-text {
        max-height: 3.6em; /* ~2 рядки */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* кількість рядків */
        -webkit-box-orient: vertical;
    }

    .filter-panel h5 {
        color: #20c997;
    }

    .filter-panel .form-label {
        font-weight: 600;
        font-size: 0.95rem;
    }

    .filter-panel .form-check-label {
        font-weight: 500;
        font-size: 0.9rem;
    }
</style>