<?php
$this->Title = '' ;
?>
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
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fefefe;
        }

        /* ================== HERO ================== */

        .hero h1 {
            font-size: 2.8rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 25px;
        }

        /* ================== КАРУСЕЛЬ ================== */
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

        .text-teal {
            color: #38b6a3;
        }
        .shadow-sm {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }
        .bg-white {
            background-color: #fff;
        }
        ul li {
            margin-bottom: 8px;
        }

        /* ============== СТИЛІ ДЛЯ КАРТОК КАТЕГОРІЙ ============== */
        .category-box {
            background-color: #f8fdfb;
            border-radius: 14px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            height: 100%;
            font-size: 14.5px;
        }

        .category-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 22px rgba(0, 0, 0, 0.08);
        }

        .category-box .icon-circle {
            width: 52px;
            height: 52px;
            font-size: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            background-color: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .category-box h5 {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #1c1c1c;
        }

        .category-box ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .category-box ul li {
            padding: 4px 0;
            padding-left: 18px;
            color: #333;
            position: relative;
        }

        .category-box ul li::before {
            content: '•';
            position: absolute;
            left: 0;
            top: 4px;
            font-size: 16px;
            color: #38b6a3;
        }

        /* Індивідуальні фони */
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

        /* === КАРТОЧКИ ТОВАРІВ === */
        .product-tile {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.07);
            transition: all 0.3s ease;
            text-align: center;
            height: 100%;
            padding: 20px 15px;
        }

        .product-tile:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            max-height: 180px;
            object-fit: contain;
            border-radius: 12px;
            background: #f6f6f6;
            padding: 8px;
            margin-bottom: 10px;
            width: 100%;
            box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.03);
        }

        .product-tile h6 {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 5px;
            color: #1c1c1c;
        }

        .product-tile p {
            font-size: 16px;
            color: #38b6a3;
            font-weight: 600;
            margin-bottom: 10px;
        }

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


        /* === Переваги === */
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

        /* Індивідуальні кольори */
        .bg-delivery {
            background-color: #e9fdf8;
            border-left-color: #2fc3aa;
        }

        .bg-quality {
            background-color: #f3f0ff;
            border-left-color: #a275d3;
        }

        .bg-support {
            background-color: #fff8ec;
            border-left-color: #f4b400;
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

<!-- Категорії -->
<section class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Популярне для улюбленців</h2>
        <p class="text-muted">Оберіть основну категорію — і вперед за покупками!</p>
    </div>

    <div class="row g-4">
        <!-- Харчування -->
        <div class="col-md-4">
            <div class="category-box bg-food">
                <div class="icon-circle">🍖</div>
                <h5>Харчування</h5>
                <ul>
                    <li>Сухий корм</li>
                    <li>Вологий корм</li>
                    <li>Ласощі</li>
                    <li>Миски та контейнери</li>
                </ul>
            </div>
        </div>

        <!-- Ветеринарія -->
        <div class="col-md-4">
            <div class="category-box bg-health">
                <div class="icon-circle">💊</div>
                <h5>Ветеринарія</h5>
                <ul>
                    <li>Вітаміни</li>
                    <li>Від бліх і кліщів</li>
                    <li>Гігієнічні засоби</li>
                    <li>Пелюшки, туалети</li>
                </ul>
            </div>
        </div>

        <!-- Прогулянка -->
        <div class="col-md-4">
            <div class="category-box bg-play">
                <div class="icon-circle">🎾</div>
                <h5>Прогулянка та дозвілля</h5>
                <ul>
                    <li>Іграшки</li>
                    <li>Амуніція</li>
                    <li>Сумки, перенесення</li>
                    <li>Лежаки, одяг</li>
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- Популярні товари -->
<section class="container my-0">
    <h3 class="text-center fw-bold mb-4">Популярні товари</h3>
    <div class="row row-cols-1 row-cols-md-4 g-4">

        <!-- Товар 1 -->
        <div class="col">
            <div class="product-tile p-3">
                <img src="/public/img/f1.webp" class="img-fluid product-img" alt="Корм для котів">
                <h6 class="mt-3 fw-semibold">Корм для котів Optimeal</h6>
                <p class="text-teal fw-bold mb-2">199 грн</p>
                <button class="btn btn-petizoo w-100">
                    <i class="bi bi-cart"></i> До кошика
                </button>
            </div>
        </div>

        <!-- Товар 2 -->
        <div class="col">
            <div class="product-tile p-3">
                <img src="/public/img/dog-treat.jpg" class="img-fluid product-img" alt="Ласощі для собак">
                <h6 class="mt-3 fw-semibold">Ласощі для собак Brit</h6>
                <p class="text-teal fw-bold mb-2">85 грн</p>
                <button class="btn btn-petizoo w-100">
                    <i class="bi bi-cart"></i> До кошика
                </button>
            </div>
        </div>

    </div>
</section>

<!-- Переваги -->
<section class="container mt-4 mb-5 features-section">
    <h3 class="text-center mb-4 fw-bold">Чому Petizoo?</h3>
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
</body>
</html>