<?php /** @var array $product */ ?>

<?php
$isFavorite = false;
if (\models\Users::IsUserLogged()) {
    $isFavorite = !empty(\core\Core::get()->db->select('favorites', '*', [
        'user_id' => $_SESSION['user']['id'],
        'product_id' => $product['id']
    ]));
}
?>

<div class="container my-5">
    <div class="row">
        <!-- Зображення товару -->
        <div class="position-relative d-inline-block w-100" style="max-height: 400px;">
            <!-- Бейдж ХІТ -->
            <?php if (!empty($product['is_popular'])): ?>
                <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark px-3 py-2 shadow fw-bold"
                      style="font-size: 0.9rem; border-radius: 8px; border: 1px solid #ffc107;">🔥 ХІТ</span>
            <?php endif; ?>

            <!-- Бейдж SALE -->
            <?php if (!empty($product['is_discounted'])): ?>
                <span class="position-absolute top-0 start-0 m-2 px-3 py-1 fw-bold shadow"
                      style="background: linear-gradient(135deg, #ff3e3e, #b30000); color: #fff; font-size: 0.85rem; border-radius: 6px 0 6px 0; border: 1px solid #aa0000;">ЗНИЖКА!</span>
            <?php endif; ?>

            <img src="/<?= isset($product['image']) && $product['image'] ? ltrim($product['image'], '/') : 'images/no-image.png' ?>"
                 class="img-fluid rounded shadow-sm w-100"
                 alt="<?= isset($product['name']) ? htmlspecialchars($product['name']) : 'Назва відсутня' ?>"
                 style="max-height: 400px; object-fit: contain;">
        </div>

        <!-- Інформація про товар -->
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-3"><?= isset($product['name']) ? htmlspecialchars($product['name']) : 'Назва недоступна' ?></h2>
            <p class="text-muted mb-4"><?= isset($product['description']) ? nl2br(htmlspecialchars($product['description'])) : 'Опис відсутній' ?></p>

            <div class="mb-4">
                <?php if (!empty($product['is_discounted']) && !empty($product['old_price'])): ?>
                    <span class="text-muted text-decoration-line-through fs-5 me-2">
            <?= number_format((float)$product['old_price'], 2) ?> грн
        </span>
                    <span class="fw-bold fs-4 text-danger">
            <?= number_format((float)$product['price'], 2) ?> грн
        </span>
                <?php else: ?>
                    <span class="fw-bold fs-4 text-teal">
            <?= number_format((float)$product['price'], 2) ?> грн
        </span>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-3">
                <!-- Кнопка додавання до кошика -->
                <button
                        class="btn btn-outline-teal btn-icon shadow-sm btn-add-to-cart"
                        data-id="<?= (int)($product['id'] ?? 0) ?>">
                    <i class="bi bi-cart-plus me-2"></i> Додати до кошика
                </button>
                <!-- Кнопка "Улюблене" -->
                <?php if (\models\Users::IsUserLogged()): ?>
                    <button class="btn btn-outline-danger shadow-sm toggle-favorite"
                            data-product-id="<?= $product['id'] ?>">
                        <i class="bi <?= $isFavorite ? 'bi-heart-fill text-danger' : 'bi-heart' ?> me-1"></i> Улюблене
                    </button>
                <?php else: ?>
                    <button class="btn btn-outline-danger shadow-sm disabled-heart"
                            title="Увійдіть до облікового запису, щоб додати товар до улюблених">
                        <i class="bi bi-heart me-1"></i> Улюблене
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Додавання до кошика (твоя логіка)
        const cartButtons = document.querySelectorAll('.btn-add-to-cart');
        cartButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.dataset.id;

                fetch(`/cart/ajaxadd/${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const badge = document.getElementById('cart-badge');
                            if (badge) {
                                badge.textContent = data.count;
                            } else {
                                const cartBtn = document.querySelector('a[href="/cart/index"]');
                                if (cartBtn) {
                                    const newBadge = document.createElement('span');
                                    newBadge.id = 'cart-badge';
                                    newBadge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                                    newBadge.textContent = data.count;
                                    cartBtn.appendChild(newBadge);
                                }
                            }
                        } else {
                            alert('Не вдалося додати товар до кошика');
                        }
                    });
            });
        });

        // Додавання/видалення з улюблених без перезавантаження
        const favButton = document.querySelector('.toggle-favorite');
        if (favButton) {
            favButton.addEventListener('click', function (e) {
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
        }
    });
</script>
<style>
    .disabled-heart {
        opacity: 1;
        cursor: not-allowed;
        position: relative;
        border: 1px solid #dc3545 !important;
    }

    .disabled-heart:hover::after {
        content: attr(title);
        position: absolute;
        bottom: -36px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #f8d7da;
        color: #721c24;
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 5px;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        z-index: 9999;
    }

    .disabled-heart i {
        pointer-events: none;
    }
</style>