<?php
/** @var array $errors */
?>

<div class="container my-5" style="max-width: 450px;">
    <h2 class="mb-4 text-center" style="color: #2ca9bc; font-weight: 700;">Реєстрація</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger rounded shadow-sm" role="alert" style="font-size: 0.95rem;">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="inputLogin" class="form-label fw-semibold text-secondary">Логін / email</label>
            <input
                    id="inputLogin"
                    name="login"
                    type="email"
                    class="form-control rounded-4 border border-info shadow-sm"
                    value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                    required
                    placeholder="Введіть ваш email"
            >
        </div>

        <div class="mb-3">
            <label for="inputPassword" class="form-label fw-semibold text-secondary">Пароль</label>
            <input
                    id="inputPassword"
                    name="password"
                    type="password"
                    class="form-control rounded-4 border border-info shadow-sm"
                    required
                    placeholder="Введіть пароль"
            >
        </div>

        <div class="mb-3">
            <label for="inputPasswordConfirm" class="form-label fw-semibold text-secondary">Повторіть пароль</label>
            <input
                    id="inputPasswordConfirm"
                    name="password_confirm"
                    type="password"
                    class="form-control rounded-4 border border-info shadow-sm"
                    required
                    placeholder="Повторіть пароль"
            >
        </div>

        <div class="mb-3">
            <label for="inputLastname" class="form-label fw-semibold text-secondary">Прізвище</label>
            <input
                    id="inputLastname"
                    name="lastname"
                    type="text"
                    class="form-control rounded-4 border border-info shadow-sm"
                    value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>"
                    required
                    placeholder="Введіть прізвище"
            >
        </div>

        <div class="mb-4">
            <label for="inputFirstname" class="form-label fw-semibold text-secondary">Ім'я</label>
            <input
                    id="inputFirstname"
                    name="firstname"
                    type="text"
                    class="form-control rounded-4 border border-info shadow-sm"
                    value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>"
                    required
                    placeholder="Введіть ім'я"
            >
        </div>

        <button type="submit" class="btn btn-info w-100 fw-semibold rounded-4 py-2 text-white">
            Зареєструватися
        </button>
    </form>
</div>
<style>
    body {
        background-color: #e9f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-control:focus {
        box-shadow: 0 0 10px rgba(44, 169, 188, 0.7);
        border-color: #1e8ca3;
        outline: none;
    }

    .btn-info {
        background-color: #2ca9bc;
        color: white;
        border: none;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-info:hover {
        background-color: #1e8ca3;
        box-shadow: 0 6px 15px rgba(30, 140, 163, 0.7);
    }
</style>
