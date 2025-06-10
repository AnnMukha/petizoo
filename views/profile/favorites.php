<?php /** @var array $favorites */?>
<div class="sale-title-wrapper text-center my-4">
    <h2 class="sale-title">Улюблені товари <span class="text-warning">🐾</span></h2>
</div>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 px-4">
    <?php if (!empty($favorites)): ?>
        <?php foreach ($favorites as $product): ?>
            <div class="col fade-wrapper">
                <div class="card product-card h-100 shadow-sm rounded-4 position-relative">
                    <?php if (!empty($product['is_discounted'])): ?>
                        <span class="badge bg-danger position-absolute start-0 top-0 m-2 shadow">ЗНИЖКА</span>
                    <?php endif; ?>
                    <?php if (!empty($product['is_popular'])): ?>
                        <span class="badge bg-warning text-dark position-absolute end-0 top-0 m-2 shadow">ХІТ</span>
                    <?php endif; ?>

                    <div class="product-img-wrapper bg-light d-flex align-items-center justify-content-center p-4">
                        <img src="/<?= ltrim($product['image'], '/') ?>"
                             class="card-img-top img-fluid"
                             alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    <div class="card-body text-center px-3 py-2">
                        <h5 class="card-title fw-bold text-dark text-truncate" title="<?= htmlspecialchars($product['name']) ?>">
                            <?= htmlspecialchars($product['name']) ?>
                        </h5>
                        <p class="card-text small text-muted overflow-hidden" style="max-height: 50px;">
                            <?= htmlspecialchars($product['description']) ?>
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center px-3 pb-3">
                        <div class="d-flex flex-column align-items-start">
                            <?php if (!empty($product['is_discounted']) && $product['new_price'] !== null): ?>
                                <small class="text-muted text-decoration-line-through">
                                    <?= number_format($product['price'], 2) ?> грн
                                </small>
                                <span class="text-danger fw-bold fs-5">
                                    <?= number_format($product['new_price'], 2) ?> грн
                                </span>
                            <?php else: ?>
                                <span class="fw-bold text-teal fs-5">
                                    <?= number_format($product['price'], 2) ?> грн
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex gap-2">
                            <form method="post" action="/products/favorite" style="display:inline">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button class="btn btn-outline-danger btn-icon shadow-sm toggle-favorite"
                                        data-product-id="<?= $product['id'] ?>"
                                        title="Прибрати з улюблених">
                                    <i class="bi bi-heart-fill text-danger fs-5"></i>
                                </button>
                            </form>
                            <a href="/cart/ajaxadd/<?= $product['id'] ?>"
                               class="btn btn-outline-teal btn-icon shadow-sm btn-add-to-cart"
                               data-id="<?= $product['id'] ?>" title="Додати до кошика">
                                <i class="bi bi-cart-plus fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center fw-semibold text-muted">У вас немає улюблених товарів 😿</p>
    <?php endif; ?>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-favorite').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                const card = this.closest('.col');

                fetch('/products/favoriteajax', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'product_id=' + productId
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'removed') {
                            card.classList.add('fade-out');
                            setTimeout(() => {
                                card.remove();
                                if (document.querySelectorAll('.col').length === 0) {
                                    const emptyMessage = document.createElement('p');
                                    emptyMessage.className = 'text-center fw-semibold text-muted';
                                    emptyMessage.textContent = 'У вас немає улюблених товарів 😿';
                                    document.querySelector('.row').appendChild(emptyMessage);
                                }
                            }, 300);
                        }
                    });
            });
        });
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
            const card = this.closest('.col');

            fetch('/products/favoriteajax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'product_id=' + productId
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'removed') {
                        // Анімація зникнення
                        card.classList.add('fade-out');
                        setTimeout(() => {
                            card.remove();

                            // Якщо більше немає товарів, виводимо повідомлення
                            if (document.querySelectorAll('.col').length === 0) {
                                const emptyMessage = document.createElement('p');
                                emptyMessage.className = 'text-center fw-semibold text-muted';
                                emptyMessage.textContent = 'У вас немає улюблених товарів 😿';
                                document.querySelector('.row').appendChild(emptyMessage);
                            }
                        }, 300);
                    }
                });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-favorite').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                const card = this.closest('.col');

                fetch('/products/favoriteajax', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'product_id=' + productId
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'removed') {
                            card.classList.add('fade-out');
                            setTimeout(() => {
                                card.remove();
                                if (document.querySelectorAll('.col').length === 0) {
                                    const emptyMessage = document.createElement('p');
                                    emptyMessage.className = 'text-center fw-semibold text-muted';
                                    emptyMessage.textContent = 'У вас немає улюблених товарів 😿';
                                    document.querySelector('.row').appendChild(emptyMessage);
                                }
                            }, 450);
                        }
                    });
            });
        });
    });
</script>

<style>
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

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
     .product-card {
         transition: all 0.3s ease;
     }

    .product-card:hover {
        background-color: #fff5f7;
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(255, 105, 135, 0.1);
        border: 1px solid #ffc1cc;
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
        transition: all 0.3s ease;
    }

    .product-card:hover {
        background-color: #fff5f7;
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(255, 105, 135, 0.1);
        border: 1px solid #ffc1cc;
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

    .fade-out {
        opacity: 0;
        transform: scale(0.97);
        transition: all 0.45s ease;
    }

    .sale-title-wrapper {
        background: #fff5f5;
        padding: 1.5rem 1rem 1rem;
        border-radius: 1rem;
        border: 2px dashed #ff4c4c;
        margin-bottom: 2rem;
        box-shadow: 0 0 6px rgba(255, 76, 76, 0.08);
    }

    .sale-title {
        color: #b5838d;
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Segoe UI', sans-serif;
        margin-bottom: 0.25rem;
    }
</style>
