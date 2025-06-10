<?php /** @var array $product */ ?>
<?php /** @var array $comments */ ?>
<?php use models\Users; ?>

<link rel="stylesheet" href="/css/cart.css">

<div class="container my-5">
    <div class="row g-5 align-items-start">
        <div class="col-md-5">
            <div class="position-relative bg-white p-3 rounded-4 shadow-sm text-center">
                <?php if ($product['is_discounted']): ?>
                    <span class="position-absolute top-0 start-0 m-2 px-3 py-1 fw-bold shadow" style="background: linear-gradient(135deg, #ff3e3e, #b30000); color: #fff; font-size: 0.85rem; border-radius: 6px 0 6px 0; border: 1px solid #aa0000;">ЗНИЖКА!</span>
                <?php endif; ?>
                <?php if ($product['is_popular']): ?>
                    <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark px-3 py-2 shadow fw-bold" style="font-size: 0.9rem; border-radius: 8px; border: 1px solid #ffc107;">🔥 ХІТ</span>
                <?php endif; ?>
                <img src="/<?= ltrim($product['image'], '/') ?>"
                     onerror="this.src='/images/no-image.png'"
                     class="img-fluid rounded-4"
                     style="max-height: 260px; object-fit: contain; border: 1px solid #e0e0e0; padding: 10px;"
                     alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
        </div>

        <div class="col-md-7">
            <h2 class="fw-bold mb-2 text-primary-emphasis"><?= htmlspecialchars($product['name']) ?></h2>
            <p class="text-muted small mb-4"><?= htmlspecialchars($product['description']) ?></p>

            <div class="mb-4">
                <?php if ($product['is_discounted'] && $product['new_price'] !== null): ?>
                    <div class="fs-5">
                        <small class="text-muted text-decoration-line-through">
                            <?= number_format($product['price'], 2) ?> грн
                        </small><br>
                        <span class="text-danger fw-bold fs-3">
                            <?= number_format($product['new_price'], 2) ?> грн
                        </span>
                    </div>
                <?php else: ?>
                    <div class="fs-4 text-success fw-bold">
                        <?= number_format($product['price'], 2) ?> грн
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex flex-wrap gap-3">
                <form method="post" action="/cart/add" onsubmit="return handleDynamicAction(event)">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button class="btn btn-outline-success px-4 py-2 rounded-pill shadow-sm fw-semibold d-flex align-items-center gap-2" type="submit">
                        <i class="bi bi-cart-plus"></i> Додати до кошика
                    </button>
                </form>

                <form method="post" action="/products/favorite" onsubmit="return handleDynamicAction(event)">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <?php
                    $isFavorite = false;
                    if (Users::IsUserLogged()) {
                        $favCheck = \core\Core::get()->db->select('favorites', '*', [
                            'user_id' => $_SESSION['user']['id'],
                            'product_id' => $product['id']
                        ]);
                        $isFavorite = !empty($favCheck);
                    }
                    ?>
                    <button class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm fw-semibold d-flex align-items-center gap-2" type="submit">
                        <i class="bi <?= $isFavorite ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i> Улюблене
                    </button>
                </form>
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
</div>

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