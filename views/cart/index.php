<?php /** @var array $items */ ?>
<?php /** @var bool $isGuest */ ?>
<link rel="stylesheet" href="/css/cart.css">

<div class="cart-title-wrapper text-center">
    <h2 class="cart-title">🛒 Мій кошик</h2>
</div>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if ($isGuest): ?>
    <div class="discount-alert">
        <div class="text">
            🐾 Ви не авторизовані. Зареєструйтесь, щоб зберігати історію покупок і отримати
            <strong>5% знижку</strong>, а також бути першим в курсі акцій!
            <div class="mt-2">
                <a href="/users/register" class="btn btn-sm btn-success">Зареєструватись</a>
                <a href="/users/login" class="btn btn-sm btn-outline-success">Увійти</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['error_messages'])): ?>
    <div class="container">
        <?php foreach ($_SESSION['error_messages'] as $msg): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
        <?php endforeach; ?>
        <?php unset($_SESSION['error_messages']); ?>
    </div>
<?php endif; ?>

<?php if (!empty($items)): ?>
    <form method="post" action="/cart/update">
        <div class="container">
            <table class="table table-cart text-center align-middle">
                <thead>
                <tr>
                    <th>Фото</th>
                    <th>Назва</th>
                    <th>Ціна</th>
                    <th>Кількість</th>
                    <th>Разом</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                <?php $total = 0; ?>
                <?php foreach ($items as $item): ?>
                    <?php $sum = $item['price'] * $item['quantity']; ?>
                    <?php $total += $sum; ?>
                    <tr>
                        <td><img src="/<?= ltrim($item['image'], '/') ?>" width="80" alt=""></td>
                        <td class="fw-semibold"><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> грн</td>
                        <td>
                            <input type="number"
                                   name="quantities[<?= $item['product_id'] ?>]"
                                   class="input-quantity"
                                   min="1"
                                   max="<?= $item['stock'] ?>"
                                   value="<?= $item['quantity'] ?>">
                            <small class="text-muted d-block">На складі: <?= $item['stock'] ?></small>
                        </td>
                        <td><?= number_format($sum, 2) ?> грн</td>
                        <td>
                            <button type="submit"
                                    name="remove"
                                    value="<?= $item['product_id'] ?>"
                                    class="btn btn-sm btn-danger">
                                Видалити
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Усього:</td>
                    <td class="fw-bold"><?= number_format($total, 2) ?> грн</td>
                    <td>
                        <a href="/checkout" class="btn btn-success btn-sm">Оформити замовлення</a>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-end">
                <button type="submit" class="btn update-btn">Оновити кошик</button>
            </div>
        </div>
    </form>
<?php else: ?>
    <p class="text-center text-muted">Кошик порожній 😿</p>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('input[type="number"][name^="quantities"]');

        inputs.forEach(input => {
            input.addEventListener('change', () => {
                localStorage.setItem('scrollY', window.scrollY);
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/cart/update';

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `quantities[${input.name.match(/\d+/)[0]}]`;
                hiddenInput.value = input.value;

                form.appendChild(hiddenInput);
                document.body.appendChild(form);
                form.submit();
            });
        });

        const y = localStorage.getItem('scrollY');
        if (y !== null) {
            window.scrollTo(0, parseInt(y));
            localStorage.removeItem('scrollY');
        }
    });
</script>
