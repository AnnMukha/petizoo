<?php
$this->Title = '' ;
?>
<?php $currentSubcategory = $_GET['subcategory'] ?? null; ?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Petizoo — Зоотовари з турботою</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* ========================
         1. Загальні стилі
        =========================== */
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fefefe;
        }
        .shadow-sm {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }
        .text-teal {
            color: #38b6a3;
        }

        /* ========================
           2. Карусель (Hero)
        =========================== */
        .carousel-item img {
            width: 100vw;
            height: auto;
            object-fit: cover;
        }
        .carousel-fullscreen {
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            overflow: hidden;
        }

        /* ========================
           3. Іконки
        =========================== */
        .icon-circle {
            background-color: #fff;
            color: #38b6a3;
            width: 60px;
            height: 60px;
            font-size: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease-in-out;
        }

        /* ========================
           4. Категорії: Блоки
        =========================== */
        .category-box {
            border-radius: 16px;
            padding: 24px 20px;
            text-align: left;
            font-size: 15.5px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            min-height: 300px;
            position: relative;
        }
        .category-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.07);
        }
        .category-box h5 {
            font-weight: 800;
            font-size: 1.25rem;
            margin-bottom: 14px;
            color: #1c1c1c;
            transition: color 0.3s ease;
        }
        .category-box:hover h5 {
            color: #38b6a3;
        }

        /* ========================
           5. Категорії: Підкатегорії
        =========================== */
        .category-box ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }
        .category-box ul li {
            margin: 0;
            padding: 0;
        }
        .category-box ul li a {
            display: block;
            padding: 8px 16px 8px 32px;
            border-radius: 10px;
            font-weight: 500;
            position: relative;
            color: #00796b;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .category-box ul li a::before {
            content: "›";
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            opacity: 0.6;
            color: #38b6a3;
        }
        .bg-food ul li a:hover {
            background-color: #ffeef0;
            color: #c92a44;
        }
        .bg-health ul li a:hover {
            background-color: #e7fbf7;
            color: #008c7a;
        }
        .bg-play ul li a:hover {
            background-color: #fff9e6;
            color: #a68300;
        }
        .category-box ul li a:hover {
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        /* ========================
           6. Колірні схеми блоків
        =========================== */
        .bg-food {
            background-color: #fff1f2;
            border-left: 5px solid #ff6b81;
        }
        .bg-health {
            background-color: #f0fdfa;
            border-left: 5px solid #38b6a3;
        }
        .bg-play {
            background-color: #fffceb;
            border-left: 5px solid #fbc02d;
        }

        /* ========================
           7. Плитки товарів
        =========================== */
        .product-tile {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            text-align: center;
            height: 100%;
            padding: 20px 15px;
            min-width: 230px;
        }
        .product-tile:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        }
        .product-tile h6 {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 6px;
            color: #333;
            height: 38px;
            overflow: hidden;
            line-height: 1.2;
        }
        .product-tile p {
            font-size: 15px;
            color: #38b6a3;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .product-img {
            height: 160px;
            width: 100%;
            object-fit: contain;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 12px;
        }

        /* ========================
           8. Кнопки
        =========================== */
        .btn-petizoo {
            background-color: #38b6a3;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 20px;
            font-size: 14px;
        }
        .btn-petizoo:hover {
            background-color: #2fa191;
            transform: scale(1.03);
            box-shadow: 0 0 0 4px rgba(56, 182, 163, 0.15);
        }
        .btn-outline-teal {
            color: #38b6a3;
            border: 2px solid #38b6a3;
            background-color: transparent;
            transition: all 0.3s ease;
        }
        .btn-outline-teal:hover {
            background-color: #38b6a3;
            color: white;
            box-shadow: 0 0 0 4px rgba(56, 182, 163, 0.15);
        }

        /* ========================
           9. Блок переваг
        =========================== */
        .features-section {
            background-color: #fefefe;
            border-radius: 20px;
            padding: 40px 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }
        .feature-box {
            border-radius: 16px;
            padding: 30px 20px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
            height: 100%;
            border-left: 6px solid transparent;
        }
        .feature-box:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 26px rgba(0,0,0,0.08);
        }
        .feature-box i {
            font-size: 36px;
            color: #fff;
            background-color: #38b6a3;
            padding: 14px;
            border-radius: 50%;
            margin-bottom: 15px;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .feature-box h6 {
            font-weight: 600;
            font-size: 1.1rem;
            color: #222;
            margin-bottom: 8px;
        }
        .feature-box p {
            font-size: 14px;
            color: #555;
        }
        .bg-delivery { background-color: #e9fdf8; border-left-color: #2fc3aa; }
        .bg-quality { background-color: #f3f0ff; border-left-color: #a275d3; }
        .bg-support { background-color: #fff8ec; border-left-color: #f4b400; }

        /* ========================
           10. Заголовки секцій
        =========================== */
        .section-title {
            font-size: 2rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #1c1c1c;
            position: relative;
        }
        .section-title::after {
            content: "";
            width: 60px;
            height: 4px;
            background: #38b6a3;
            display: block;
            margin: 10px auto 0;
            border-radius: 3px;
        }
        .badge-sale {
            background-color: #e53935;
            color: #fff;
            font-weight: bold;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 12px;
        }
        .badge-hit {
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 12px;
        }
        .product-price-original {
            text-decoration: line-through;
            color: #888;
            font-size: 0.95rem;
        }
        .product-price-discount {
            color: #e53935;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .product-tile {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            text-align: center;
            height: 100%;
            padding: 20px 15px;
            width: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .popular-scroll {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .product-img {
            height: 160px;
            width: 100%;
            object-fit: contain;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 12px;
        }
        .product-row {
            display: flex;
            gap: 16px; /* Відступ між товарами */
            overflow-x: auto;
            padding-bottom: 10px;
            margin-bottom: 20px;
            scroll-snap-type: x mandatory; /* Опційно: для плавного скролу */
        }
        .product-tile {
            flex: 0 0 auto; /* Щоб не стискалося і не переносилося */
            scroll-snap-align: start; /* Опційно */
        }
        .product-row::-webkit-scrollbar {
            display: none;
        }
        .product-row {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body>
<!-- FULL-WIDTH CAROUSEL -->
<div class="carousel-fullscreen">
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/public/img/1.jpg" class="d-block" alt="Банер 1">
            </div>
            <div class="carousel-item">
                <img src="/public/img/2.jpg" class="d-block" alt="Банер 2">
            </div>
            <div class="carousel-item">
                <img src="/public/img/3.jpg" class="d-block" alt="Банер 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>
<!-- БЛОК СТАНЬ СВОЇМ -->
<?php if (!\models\Users::IsUserLogged()): ?>
<div class="register-banner d-flex align-items-center justify-content-between flex-wrap p-4 rounded-4 shadow-sm my-4" style="background-color: #fff7f3;">
    <div class="d-flex align-items-center flex-wrap">
        <div class="icon-circle me-3">🙌</div>
        <div>
            <h5 class="mb-1 fw-bold text-dark">Приєднуйся до світу Petizoo!</h5>
            <p class="mb-0 text-muted">
                Отримай <span class="text-danger fw-bold">+5% постійної знижки</span> та першим дізнавайся про акції 🐾
            </p>
        </div>
    </div>
    <a href="/users/register" class="btn btn-petizoo rounded-pill px-4 mt-3 mt-md-0">
        🎁 Хочу знижку!
    </a>
</div>
<?php endif; ?>
<!-- Категорії -->
<section class="container my-5">
    <div class="text-center mb-4">
        <h2 class="section-title">Популярне для улюбленців</h2>
        <p class="text-muted">Оберіть основну категорію — і вперед за покупками!</p>
    </div>

    <div class="row g-4">
        <!-- Харчування -->
        <div class="col-md-4">
            <div class="category-box bg-food position-relative">
                <a href="/products?animal=both&category=1" class="stretched-link position-absolute top-0 start-0 w-100 h-100" style="z-index:1;"></a>
                <div class="icon-circle">🍖</div>
                <h5 >Харчування</h5>
                <ul class="position-relative" style="z-index:2;">
                    <li><a href="/products?animal=both&category=1&subcategory=1" class="<?= $currentSubcategory == 1 ? 'active-sub' : '' ?>">Сухий корм</a></li>
                    <li><a href="/products?animal=both&category=1&subcategory=2" class="<?= $currentSubcategory == 2 ? 'active-sub' : '' ?>">Вологий корм</a></li>
                    <li><a href="/products?animal=both&category=1&subcategory=3" class="<?= $currentSubcategory == 3 ? 'active-sub' : '' ?>">Ласощі</a></li>
                    <li><a href="/products?animal=both&category=1&subcategory=4" class="<?= $currentSubcategory == 4 ? 'active-sub' : '' ?>">Миски та контейнери</a></li>
                </ul>
            </div>
        </div>

        <!-- Ветеринарія -->
        <div class="col-md-4">
            <div class="category-box bg-health position-relative">
                <a href="/products?animal=both&category=2" class="stretched-link position-absolute top-0 start-0 w-100 h-100" style="z-index:1;"></a>
                <div class="icon-circle">💊</div>
                <h5>Ветеринарія</h5>
                <ul class="position-relative" style="z-index:2;">
                    <li><a href="/products?animal=both&category=2&subcategory=7" class="<?= $currentSubcategory == 7 ? 'active-sub' : '' ?>">Вітаміни</a></li>
                    <li><a href="/products?animal=both&category=2&subcategory=5" class="<?= $currentSubcategory == 5 ? 'active-sub' : '' ?>">Від бліх і кліщів</a></li>
                    <li><a href="/products?animal=both&category=2&subcategory=8" class="<?= $currentSubcategory == 8 ? 'active-sub' : '' ?>">Гігієнічні засоби</a></li>
                    <li><a href="/products?animal=both&category=2&subcategory=9" class="<?= $currentSubcategory == 9 ? 'active-sub' : '' ?>">Пелюшки, туалети</a></li>
                </ul>
            </div>
        </div>

        <!-- Прогулянка -->
        <div class="col-md-4">
            <div class="category-box bg-play position-relative">
                <a href="/products?animal=both&category=3" class="stretched-link position-absolute top-0 start-0 w-100 h-100" style="z-index:1;"></a>
                <div class="icon-circle">🎾</div>
                <h5>Прогулянка та дозвілля</h5>
                <ul class="position-relative" style="z-index:2;">
                    <li><a href="/products?animal=both&category=3&subcategory=10" class="<?= $currentSubcategory == 10 ? 'active-sub' : '' ?>">Іграшки</a></li>
                    <li><a href="/products?animal=both&category=3&subcategory=15" class="<?= $currentSubcategory == 15 ? 'active-sub' : '' ?>">Амуніція</a></li>
                    <li><a href="/products?animal=both&category=3&subcategory=12" class="<?= $currentSubcategory == 12 ? 'active-sub' : '' ?>">Сумки, перенесення</a></li>
                    <li><a href="/products?animal=both&category=3&subcategory=13" class="<?= $currentSubcategory == 13 ? 'active-sub' : '' ?>">Лежаки, одяг</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Популярні товари -->
<section class="container my-0">
    <h3 class="section-title">Популярні товари</h3>

    <div class="popular-scroll d-flex gap-3 overflow-auto pb-3">
        <?php if (!empty($popular)): ?>
            <?php foreach ($popular as $item): ?>
                <div class="position-relative product-tile d-flex flex-column">
                    <?php if (!empty($item['is_discounted'])): ?>
                        <span class="position-absolute top-0 start-0 m-2 badge badge-sale shadow">ЗНИЖКА</span>
                    <?php endif; ?>

                    <?php if (!empty($item['is_popular'])): ?>
                        <span class="position-absolute top-0 end-0 m-2 badge badge-hit shadow">ХІТ</span>
                    <?php endif; ?>

                    <a href="/products/view/<?= (int)$item['id'] ?>" class="text-decoration-none text-dark">
                        <img src="<?= htmlspecialchars($item['image']) ?>" class="img-fluid product-img" alt="<?= htmlspecialchars($item['name']) ?>">
                        <h6 class="mt-3 fw-semibold text-center"><?= htmlspecialchars($item['name']) ?></h6>
                    </a>

                    <div class="text-center mb-2">
                        <?php if (!empty($item['is_discounted'])): ?>
                            <span class="product-price-original d-block text-muted text-decoration-line-through">
                                <?= number_format((float)$item['price'], 2) ?> грн
                            </span>
                            <span class="product-price-discount fw-bold text-danger">
                                <?= number_format((float)$item['new_price'], 2) ?> грн
                            </span>
                        <?php else: ?>
                            <span class="text-teal fw-bold">
                                <?= number_format((float)$item['price'], 2) ?> грн
                            </span>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="btn btn-petizoo w-100 add-to-cart mt-auto" data-id="<?= (int)$item['id'] ?>">
                        <i class="bi bi-cart"></i> До кошика
                    </button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Наразі немає популярних товарів</p>
        <?php endif; ?>
    </div>

    <!-- Кнопка до каталогу -->
    <div class="text-center mt-4">
        <a href="/products/index" class="btn btn-outline-teal rounded-pill px-5 py-2 fw-semibold shadow-sm">
            <i class="bi bi-grid-3x3-gap me-1"></i> Переглянути весь каталог
        </a>
    </div>
</section>
<!-- Переваги -->
<section class="container mt-4 mb-5 features-section">
    <h3 class="section-title">Чому Petizoo?</h3>
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="feature-box bg-delivery">
                <i class="bi bi-truck"></i>
                <h6>Швидка доставка</h6>
                <p>Відправка протягом 24 годин</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box bg-quality">
                <i class="bi bi-award"></i>
                <h6>Гарантія якості</h6>
                <p>Лише сертифіковані товари</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box bg-support">
                <i class="bi bi-chat-heart"></i>
                <h6>Турботлива підтримка</h6>
                <p>Консультації з ветеринаром</p>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".add-to-cart");

        buttons.forEach(button => {
            button.addEventListener("click", function (e) {
                e.preventDefault(); // ❗️запобігає стрибку на початок

                const productId = this.dataset.id;

                fetch(`/cart/ajaxadd/${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Оновити значок у шапці
                            const badge = document.querySelector('#cart-badge');
                            if (badge) {
                                badge.textContent = data.count;
                                badge.classList.remove("d-none");
                            }

                            // Змінити кнопку
                            this.classList.remove("btn-petizoo");
                            this.classList.add("btn-success");
                            this.innerHTML = "✅ Додано!";

                            // Через 1.5 секунди повернути кнопку назад
                            setTimeout(() => {
                                this.classList.remove("btn-success");
                                this.classList.add("btn-petizoo");
                                this.innerHTML = '<i class="bi bi-cart"></i> До кошика';
                            }, 1500);

                            // Оновити вміст кошика, якщо є контейнер
                            fetch('/cart/ajaxhtml') // ❗️створи новий метод, який повертає HTML кошика
                                .then(res => res.text())
                                .then(html => {
                                    const cartDropdown = document.querySelector('#cart-dropdown-content');
                                    if (cartDropdown) {
                                        cartDropdown.innerHTML = html;
                                    }
                                });
                        } else {
                            alert("Не вдалося додати товар");
                        }
                    });
            });
        });
    });
</script>
</body>
</html>