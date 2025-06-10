<?php /** @var array $product */ ?>
<?php /** @var array $comments */ ?>
<?php use models\Users; ?>

<link rel="stylesheet" href="/css/cart.css">
<style>
    .product-image-box {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border-radius: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        padding: 25px;
        transition: box-shadow 0.3s ease;
    }
    .product-image-box:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }
    .product-title {
        font-size: 1.9rem;
        color: #1a1a1a;
        font-weight: 700;
    }
    .product-description {
        background-color: #fdfdfd;
        padding: 18px 22px;
        border-left: 5px solid #20c997;
        border-radius: 0.75rem;
        font-size: 1rem;
        line-height: 1.65;
        color: #555;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.025);
        margin-bottom: 1.5rem;
    }
    .product-price-old {
        font-size: 1rem;
        text-decoration: line-through;
        color: #888;
    }
    .product-price-new {
        font-size: 1.8rem;
        color: #dc3545;
        font-weight: bold;
    }
    .product-price-normal {
        font-size: 1.6rem;
        color: #198754;
        font-weight: bold;
    }
    .product-actions .btn {
        font-size: 0.95rem;
        padding: 10px 20px;
        border-radius: 50px;
    }
    .btn-disabled-tooltip {
        position: relative;
        opacity: 1;
        cursor: not-allowed;
        border: 1px solid #dc3545 !important;
        background-color: transparent;
        pointer-events: auto;
        border-radius: 50px;
    }
    .btn-disabled-tooltip::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: -36px;
        right: -10px;
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
</style>

<div class="container my-5">
    <div class="row g-5 align-items-start">
        <div class="col-md-5">
            <div class="position-relative product-image-box text-center">
                <?php if ($product['is_discounted']): ?>
                    <span class="position-absolute top-0 start-0 m-2 px-3 py-1 fw-bold shadow" style="background: linear-gradient(135deg, #ff3e3e, #b30000); color: #fff; font-size: 0.85rem; border-radius: 6px 0 6px 0; border: 1px solid #aa0000;">ЗНИЖКА!</span>
                <?php endif; ?>
                <?php if ($product['is_popular']): ?>
                    <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark px-3 py-2 shadow fw-bold" style="font-size: 0.9rem; border-radius: 8px; border: 1px solid #ffc107;">🔥 ХІТ</span>
                <?php endif; ?>
                <img src="/<?= ltrim($product['image'], '/') ?>"
                     onerror="this.src='/images/no-image.png'"
                     class="img-fluid rounded-4"
                     style="max-height: 260px; object-fit: contain;"
                     alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
        </div>

        <div class="col-md-7">
            <h2 class="product-title mb-3"><?= htmlspecialchars($product['name']) ?></h2>

            <h5 class="text-uppercase text-secondary fw-semibold mb-2">Опис товару</h5>
            <div class="product-description">
                <?= nl2br(htmlspecialchars($product['description'])) ?>
            </div>

            <div class="mb-4">
                <?php if ($product['is_discounted'] && $product['new_price'] !== null): ?>
                    <div>
                        <div class="product-price-old"><?= number_format($product['price'], 2) ?> грн</div>
                        <div class="product-price-new"><?= number_format($product['new_price'], 2) ?> грн</div>
                    </div>
                <?php else: ?>
                    <div class="product-price-normal"><?= number_format($product['price'], 2) ?> грн</div>
                <?php endif; ?>
            </div>

            <div class="d-flex flex-wrap gap-3 product-actions">
                <form method="post" action="/cart/add" onsubmit="return handleDynamicAction(event)">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button class="btn btn-outline-success shadow-sm fw-semibold d-flex align-items-center gap-2" type="submit">
                        <i class="bi bi-cart-plus"></i> Додати до кошика
                    </button>
                </form>

                <?php if (Users::IsUserLogged()): ?>
                    <form method="post" action="/products/favorite" onsubmit="return handleDynamicAction(event)">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <?php
                        $favCheck = \core\Core::get()->db->select('favorites', '*', [
                            'user_id' => $_SESSION['user']['id'],
                            'product_id' => $product['id']
                        ]);
                        $isFavorite = !empty($favCheck);
                        ?>
                        <button class="btn btn-outline-danger shadow-sm fw-semibold d-flex align-items-center gap-2" type="submit">
                            <i class="bi <?= $isFavorite ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i> Улюблене
                        </button>
                    </form>
                <?php else: ?>
                    <div class="position-relative">
                        <button type="button"
                                class="btn btn-outline-danger shadow-sm fw-semibold d-flex align-items-center gap-2 btn-disabled-tooltip"
                                data-tooltip="Увійдіть у акаунт, щоб додати до улюбленого">
                            <i class="bi bi-heart"></i> Улюблене
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    <hr class="my-5">
    <h4 class="mb-4"><i class="bi bi-chat-left-text me-2"></i>Коментарі</h4>
    <?php if (Users::IsUserLogged()): ?>
        <form method="post" action="/products/addcomment" class="mb-5" onsubmit="return handleDynamicAction(event)">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <div class="mb-3">
                <textarea name="content" class="form-control shadow-sm rounded-3" rows="3" placeholder="Ваш коментар..."></textarea>
            </div>
            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">Надіслати</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning shadow-sm rounded-3">Увійдіть або зареєструйтесь, щоб залишити коментар.</div>
    <?php endif; ?>

    <?php if (!empty($comments)): ?>
        <div class="list-group">
            <?php foreach ($comments as $comment): ?>
                <div class="list-group-item mb-3 border rounded-3 shadow-sm">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <span class="fw-semibold">👤 <?= htmlspecialchars($comment['login'] ?? 'Невідомий') ?></span>
                        <span><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>
                    </div>
                    <p class="mb-2">📝 <?= nl2br(htmlspecialchars($comment['comment'])) ?></p>

                    <?php if (Users::IsUserLogged() && $_SESSION['user']['id'] === $comment['user_id']): ?>
                        <button type="button" class="btn btn-link btn-sm text-primary edit-comment-toggle">✏️ Редагувати</button>
                        <form method="post" action="/products/updatecomment" class="edit-comment-form d-none mt-3" onsubmit="return handleDynamicAction(event)">
                            <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <textarea name="content" class="form-control mb-2"><?= htmlspecialchars($comment['comment']) ?></textarea>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success btn-sm">💾 Зберегти</button>
                                <button type="button" class="btn btn-secondary btn-sm cancel-edit">❌ Скасувати</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">Коментарі відсутні.</p>
    <?php endif; ?>
<script>
    document.querySelectorAll('.edit-comment-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            const commentItem = btn.closest('.list-group-item');
            const form = commentItem.querySelector('.edit-comment-form');
            form.classList.toggle('d-none');
        });
    });

    document.querySelectorAll('.cancel-edit').forEach((btn) => {
        btn.addEventListener('click', () => {
            const form = btn.closest('.edit-comment-form');
            form.classList.add('d-none');
        });
    });

    function handleDynamicAction(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        fetch(form.action, {
            method: form.method,
            body: formData,
        }).then(() => {
            window.location.reload();
        });
        return false;
    }
</script>