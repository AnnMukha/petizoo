<?php /** @var array $products */ ?>
<?php /** @var array $categories */ ?>
<?php /** @var string $animal */ ?>
<?php /** @var string $category */ ?>

<h2 class="text-center my-4 fw-bold text-dark display-5">Каталог товарів</h2>

<!-- 🔍 Форма фільтрації -->
<form method="get" class="text-center mb-4 d-flex justify-content-center gap-3 flex-wrap">
    <div>
        <label class="form-label fw-semibold">Тип тварини:</label>
        <select name="animal" class="form-select d-inline w-auto">
            <option value="all" <?= ($animal ?? '') === 'all' ? 'selected' : '' ?>>Усі</option>
            <option value="cat" <?= ($animal ?? '') === 'cat' ? 'selected' : '' ?>>Котам</option>
            <option value="dog" <?= ($animal ?? '') === 'dog' ? 'selected' : '' ?>>Собакам</option>
            <option value="both" <?= ($animal ?? '') === 'both' ? 'selected' : '' ?>>Котам і собакам</option>
        </select>
    </div>
    <div>
        <label class="form-label fw-semibold">Підкатегорія:</label>
        <select name="category" class="form-select d-inline w-auto">
            <option value="all" <?= ($category ?? '') === 'all' ? 'selected' : '' ?>>Усі</option>
            <?php foreach ($categories as $subcategory): ?>
                <option value="<?= $subcategory['id'] ?>" <?= ($category ?? '') == $subcategory['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($subcategory['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="align-self-end">
        <button type="submit" class="btn btn-outline-teal">Фільтрувати</button>
    </div>
</form>

<!-- 🛒 Вивід товарів -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 px-4">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card product-card h-100 shadow-sm rounded-4 position-relative">
                    <div class="product-img-wrapper bg-light d-flex align-items-center justify-content-center p-4">
                        <img src="/<?= ltrim($product['image'], '/') ?>"
                             class="card-img-top img-fluid"
                             alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    <div class="card-body text-center px-3 py-2">
                        <h5 class="card-title fw-bold text-dark"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text small text-muted"><?= htmlspecialchars($product['description']) ?></p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center px-3 pb-3">
                        <span class="fw-bold text-teal fs-5"><?= number_format($product['price'], 2) ?> грн</span>
                        <div class="d-flex gap-3">
                            <a href="/cart/ajaxadd/<?= $product['id'] ?>"
                               class="btn btn-outline-teal btn-icon shadow-sm btn-add-to-cart"
                               data-id="<?= $product['id'] ?>" title="Додати до кошика">
                                <i class="bi bi-cart-plus fs-5"></i>
                            </a>
                            <!-- У каталозі: -->
                            <?php if (\models\Users::IsUserLogged()): ?>
                                <?php
                                $isFavorite = \core\Core::get()->db->select('favorites', '*', [
                                    'user_id' => $_SESSION['user']['id'],
                                    'product_id' => $product['id']
                                ]);
                                ?>
                                <button class="btn btn-outline-danger btn-icon shadow-sm toggle-favorite"
                                        data-product-id="<?= $product['id'] ?>"
                                        title="У вибране">
                                    <i class="bi <?= $isFavorite ? 'bi-heart-fill text-danger' : 'bi-heart' ?> fs-5"></i>
                                </button>
                            <?php else: ?>
                                <button onclick="alert('Доступно лише для авторизованих користувачів!')"
                                        class="btn btn-outline-danger btn-icon shadow-sm" title="У вибране">
                                    <i class="bi bi-heart fs-5"></i>
                                </button>
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
<script>
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
</style>

