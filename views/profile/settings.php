<?php
/** @var array $user */
/** @var array $errors */
/** @var string|null $success */
?>

<div class="container">
    <h2 class="mb-4">Налаштування профілю</h2>

    <div class="row">
        <!-- ФОРМА ОНОВЛЕННЯ -->
        <div class="col-md-7">
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- ІМ’Я -->
            <form method="post" class="mb-3 d-flex align-items-center gap-2" novalidate>
                <input type="hidden" name="field" value="firstname">
                <input type="text" name="value" class="form-control" required
                       value="<?= htmlspecialchars($user['firstname'] ?? '') ?>" placeholder="Ім’я">
                <button class="btn btn-success">Зберегти</button>
            </form>

            <!-- EMAIL -->
            <form method="post" class="mb-3 d-flex align-items-center gap-2" novalidate>
                <input type="hidden" name="field" value="email">
                <input type="email" name="value" class="form-control" required
                       value="<?= htmlspecialchars($user['login'] ?? '') ?>" placeholder="Email">
                <button class="btn btn-success">Зберегти</button>
            </form>

            <!-- ТЕЛЕФОН -->
            <form method="post" class="mb-3 d-flex align-items-center gap-2" novalidate>
                <input type="hidden" name="field" value="phone">
                <input type="tel" name="value" class="form-control" required
                       pattern="^\+380\d{9}$"
                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Телефон +380...">
                <button class="btn btn-success">Зберегти</button>
            </form>
            <!-- ПАРОЛЬ -->
            <form method="post" class="mb-3 d-flex align-items-center gap-2">
                <input type="hidden" name="field" value="password">
                <input type="password" name="value" class="form-control" placeholder="Новий пароль" required>
                <button class="btn btn-success">Зберегти</button>
            </form>
        </div>

        <!-- ІНФОРМАЦІЯ ПРО КОРИСТУВАЧА -->
        <div class="col-md-5">
            <div class="bg-white border rounded p-4 shadow-sm">
                <h5 class="mb-3 text-teal"><i class="bi bi-person-circle me-2"></i>Поточна інформація</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <strong>Ім’я:</strong><br>
                        <?= htmlspecialchars($user['firstname'] ?? '-') ?>
                    </li>
                    <li class="mb-2">
                        <strong>Email:</strong><br>
                        <?= htmlspecialchars($user['login'] ?? '-') ?>
                    </li>
                    <li class="mb-2">
                        <strong>Телефон:</strong><br>
                        <?= htmlspecialchars($user['phone'] ?? '-') ?>
                    </li>
                    <li class="mb-2">
                        <strong>Дата приєднання:</strong><br>
                        <?= date('d.m.Y', strtotime($user['created_at'] ?? 'now')) ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
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
    })();
</script>

