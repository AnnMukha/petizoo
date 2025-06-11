<?php
/** @var string $error_message Повідомлення про помилку */
$this->Title = '';
?>

<div class="container my-5" style="max-width: 450px;">
    <h2 class="mb-4 text-center" style="color: #2ca9bc; font-weight: 700;">Вхід на сайт</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger rounded shadow-sm" role="alert" style="font-size: 0.95rem;">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-4">
            <label for="inputEmail" class="form-label fw-semibold text-secondary">Логін / email</label>
            <input
                    name="login"
                    type="email"
                    class="form-control rounded-4 border border-info shadow-sm"
                    id="inputEmail"
                    aria-describedby="emailHelp"
                    value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                    required
                    placeholder="Введіть ваш email"
            >
            <div id="emailHelp" class="form-text text-muted">Введіть ваш робочий email</div>
        </div>

        <div class="mb-4">
            <label for="inputPassword" class="form-label fw-semibold text-secondary">Пароль</label>
            <input
                    name="password"
                    type="password"
                    class="form-control rounded-4 border border-info shadow-sm"
                    id="inputPassword"
                    required
                    placeholder="Введіть пароль"
            >
        </div>

        <button type="submit" class="btn btn-info w-100 fw-semibold rounded-4 py-2 text-white">
            Увійти
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
