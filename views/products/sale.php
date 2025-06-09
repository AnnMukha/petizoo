<?php /** @var array $products */ ?>

<div class="sale-title-wrapper text-center my-4">
    <h2 class="sale-title">Знижки для улюбленців <span class="text-warning">🔥</span></h2>
    <p class="sale-subtitle">Обирайте товари за суперцінами тільки сьогодні 💝</p>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 px-4">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card product-card h-100 shadow-sm rounded-4 position-relative">
                    <span class="position-absolute top-0 start-0 m-2 px-3 py-1 fw-bold shadow"
                          style="background: linear-gradient(135deg, #ff3e3e, #b30000); color: #fff; font-size: 0.85rem; border-radius: 6px 0 6px 0; border: 1px solid #aa0000;">ЗНИЖКА!</span>

                    <a href="/products/view/<?= $product['id'] ?>" class="text-decoration-none text-dark">
                        <div class="product-img-wrapper bg-light d-flex align-items-center justify-content-center p-4" style="height: 220px;">
                            <img src="/<?= ltrim($product['image'], '/') ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div class="card-body text-center px-3 py-2">
                            <h5 class="card-title fw-bold text-dark mb-1"><?= htmlspecialchars($product['name']) ?></h5>
                        </div>
                    </a>

                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center px-3 pb-3">
                        <div class="d-flex flex-column align-items-start">
                            <small class="text-muted text-decoration-line-through">
                                <?= number_format($product['price'], 2) ?> грн
                            </small>
                            <span class="text-danger fw-bold fs-5">
                                <?= number_format($product['new_price'], 2) ?> грн
                            </span>
                        </div>

                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-teal btn-icon shadow-sm btn-add-to-cart rounded-circle" data-id="<?= $product['id'] ?>" title="Додати до кошика">
                                <i class="bi bi-cart-plus fs-5"></i>
                            </a>

                            <?php if (\models\Users::IsUserLogged()): ?>
                                <?php
                                $isFavorite = \core\Core::get()->db->select('favorites', '*', [
                                    'user_id' => $_SESSION['user']['id'],
                                    'product_id' => $product['id']
                                ]);
                                ?>
                                <button class="btn btn-outline-danger btn-icon shadow-sm toggle-favorite rounded-circle" data-product-id="<?= $product['id'] ?>" title="У вибране">
                                    <i class="bi <?= $isFavorite ? 'bi-heart-fill text-danger' : 'bi-heart' ?> fs-5"></i>
                                </button>
                            <?php else: ?>
                                <div class="position-relative">
                                    <button class="btn btn-outline-danger btn-icon shadow-sm btn-disabled-tooltip rounded-circle" data-tooltip="Увійдіть до акаунта, щоб додати в улюблене">
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
        <p class="text-center fw-semibold text-muted">Зараз немає акційних товарів 😿</p>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.dataset.id;
                fetch(`/cart/ajaxadd/${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            let badge = document.getElementById('cart-badge');
                            if (!badge) {
                                const cartBtn = document.querySelector('a[href="/cart/index"]');
                                badge = document.createElement('span');
                                badge.id = 'cart-badge';
                                badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                                cartBtn.appendChild(badge);
                            }
                            badge.textContent = data.count;
                        }
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
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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
    });
</script>

<style>
    .sale-title-wrapper {
        background: #fff5f5;
        padding: 1.5rem 1rem 1rem;
        border-radius: 1rem;
        border: 2px dashed #ff4c4c;
        margin-bottom: 2rem;
        box-shadow: 0 0 6px rgba(255, 76, 76, 0.08);
    }
    .sale-title {
        color: #dc3545;
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Segoe UI', sans-serif;
        margin-bottom: 0.25rem;
    }
    .sale-subtitle {
        color: #666;
        font-size: 1rem;
        font-style: italic;
    }
    .btn-outline-teal {
        color: #20c997;
        border-color: #20c997;
    }
    .btn-outline-teal:hover {
        background-color: #20c997;
        color: white;
    }
    .btn-icon {
        width: 42px;
        height: 42px;
        padding: 6px;
        font-size: 1.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .product-card {
        background-color: #fcfcfc;
        border: 1px solid #e6e6e6;
        transition: all 0.25s ease;
        border-radius: 1.5rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }
    .product-card:hover {
        background-color: #fef9f9;
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(255, 72, 72, 0.1);
        border: 2px solid #ff4c4c;
    }
    .product-img-wrapper {
        height: 220px;
        overflow: hidden;
        border-bottom: 1px solid #f0f0f0;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        background-color: #fff9f9;
        transition: background-color 0.3s ease;
    }
    .product-img-wrapper:hover {
        background-color: #ffeaea;
    }
    .product-img-wrapper img {
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
</style>
