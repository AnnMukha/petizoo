<?php
/** @var array $items */
/** @var float $total */
/** @var bool $isGuest */
?>

<link rel="stylesheet" href="/css/cart.css">

<div class="container mt-5">
    <h2 class="text-center mb-4 text-success fw-bold">Сторінка оформлення замовлення</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!$isGuest): ?>
        <div class="alert alert-info text-center fw-medium">
            🎁 Ви авторизовані — вам автоматично нараховується <strong>знижка 5%</strong> на суму замовлення!
        </div>
    <?php endif; ?>

    <form method="post" action="/checkout/submit" class="mb-4 p-4 border rounded-4 bg-light shadow-sm needs-validation" novalidate>
        <h5 class="fw-bold">1. Особисті дані</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Ім’я та прізвище *</label>
                <input type="text" name="full_name" class="form-control" required
                       pattern="^[А-Яа-яІіЇїЄєA-Za-z\s'-]+$"
                       title="Використовуйте лише літери, апостроф і пробіли.">
                <div class="invalid-feedback">Введіть коректне ім’я та прізвище (тільки літери та пробіли).</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Телефон *</label>
                <input type="tel" id="phone" name="phone" class="form-control" required
                       pattern="^\+380\d{9}$"
                       title="Телефон у форматі +380XXXXXXXXX">
                <div class="invalid-feedback">Телефон має бути у форматі +380XXXXXXXXX</div>
            </div>
        </div>

        <h5 class="fw-bold">2. Спосіб доставки</h5>
        <div class="mb-3">
            <label class="form-label">Тип доставки</label>
            <select name="delivery_type" class="form-select" required>
                <option value="">Оберіть тип</option>
                <option value="Нова пошта">Нова пошта</option>
                <option value="Укрпошта">Укрпошта</option>
                <option value="Кур’єром">Кур’єром</option>
            </select>
            <div class="invalid-feedback">Оберіть тип доставки</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Місто *</label>
                <input type="text" name="city" class="form-control" required>
                <div class="invalid-feedback">Вкажіть місто доставки</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Відділення / Адреса *</label>
                <input type="text" name="department" class="form-control" required>
                <div class="invalid-feedback">Вкажіть відділення або адресу</div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Коментар до замовлення</label>
            <textarea name="comment" class="form-control" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Оформити замовлення</button>
    </form>

    <h4 class="mb-3">Ваші товари:</h4>
    <table class="table table-cart text-center align-middle">
        <thead>
        <tr>
            <th>Фото</th>
            <th>Назва</th>
            <th>Ціна</th>
            <th>Кількість</th>
            <th>Разом</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $subtotal = 0;
        foreach ($items as $item):
            $lineTotal = $item['price'] * $item['quantity'];
            $subtotal += $lineTotal;
            ?>
            <tr>
                <td><img src="/<?= ltrim($item['image'], '/') ?>" width="70" alt=""></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price'], 2) ?> грн</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($lineTotal, 2) ?> грн</td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" class="text-end fw-bold">Проміжна сума:</td>
            <td><?= number_format($subtotal, 2) ?> грн</td>
        </tr>
        <?php if (!$isGuest):
            $discount = round($subtotal * 0.05, 2);
            $finalTotal = $subtotal - $discount;
            ?>
            <tr>
                <td colspan="4" class="text-end text-danger fw-medium">Знижка 5%:</td>
                <td class="text-danger">−<?= number_format($discount, 2) ?> грн</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end fw-bold">До оплати:</td>
                <td class="fw-bold text-success"><?= number_format($finalTotal, 2) ?> грн</td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-end fw-bold">До оплати:</td>
                <td class="fw-bold"><?= number_format($subtotal, 2) ?> грн</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('focus', () => {
            if (phoneInput.value.trim() === '') {
                phoneInput.value = '+380';
            }
        });
    })();
</script>
