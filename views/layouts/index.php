<?php
/** @var string $Title */
/** @var string $Content */
/** @var array $categories */
/** @var array $subcategories */
if (empty($Title))
    $Title = '';
if (empty($Content))
    $Content = '';
?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= $Title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* ------------------- ОСНОВНІ СТИЛІ ------------------- */
        body {
            padding-top: 100px;
        }
        .topbar {
            background-color: #38b6a3;
            color: white;
            font-size: 14px;
        }

        .navbar-custom {
            background-color: #ffffff;
        }

        .footer-custom {
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .footer-custom a {
            color: #6c757d;
            text-decoration: none;
        }

        .footer-custom a:hover {
            color: #38b6a3;
            text-decoration: underline;
        }

        .text-teal {
            color: #38b6a3 !important;
        }
        .mega-menu {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        /* ------------------- НАВІГАЦІЯ ------------------- */
        .navbar-nav .nav-link {
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 6px;
            padding: 10px 14px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #e6f7f4;
            color: #38b6a3;
        }

        /* ------------------- DROPDOWN ------------------- */
        @media (min-width: 992px) {
            .navbar .dropdown:hover .dropdown-menu {
                display: block;
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
        }

        .dropdown-menu {
            display: none;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease-in-out;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            background-color: white;
            z-index: 1000;
        }

        /* ------------------- ПІДКАТЕГОРІЇ ------------------- */
        .dropdown-menu ul li a {
            display: block;
            padding: 4px 10px;
            border-radius: 4px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .dropdown-menu ul li a:hover {
            background-color: #f2fdfa;
            color: #009688 !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        @media (min-width: 992px) {
            .navbar .dropdown:hover .dropdown-menu {
                display: block;
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
        }

        .badge {
            padding: 2px 6px;
        }
        .dropdown-toggle span {
            font-size: 15px;
            color: #333;
        }

        .dropdown-toggle:hover span {
            color: #20c997;
        }

        .dropdown-menu i {
            width: 20px;
        }
        .navbar-nav .nav-link[href="/product/sale"]:hover {
            background-color: #fff5f5;
            color: #dc3545;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="fixed-top shadow-sm bg-white" style="z-index: 1030;">
<!-- TOPBAR -->
<div class="topbar py-2">
    <div class="container d-flex justify-content-between align-items-center">
        <span><strong>Petizoo</strong> — зоотовари з турботою про ваших улюбленців 💙</span>
        <span>Безкоштовна доставка від 500 грн 🚚</span>
    </div>
</div>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold text-teal" href="/">Petizoo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/">Головна</a></li>

                <!-- КОТАМ -->
                <li class="nav-item dropdown">
                    <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Котам</a>
                    <div class="dropdown-menu p-3" style="min-width: 1000px; padding: 28px;">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center">
                                        <i class="bi bi-bag-heart-fill fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Харчування</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=1">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Сухий корм</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=2">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Консервований корм</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=3">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Ласощі</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=4">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Миски та контейнери для дому</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center">
                                        <i class="bi bi-capsule-pill fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Здоров'я та гігієна</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=5">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Від бліх та кліщі</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=7">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Вітаміни</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=8">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Засоби для догляду</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=9">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Пелюшки та туалети</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center">
                                        <i class="bi bi-heart fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Прогулянка та дозвілля</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=10">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Іграшки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=11">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Кігтеточки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=12">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Сумки, переноски</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=13">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Лежаки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=cat&subcategory=14">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Нашийники, довідки, шлеї</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- СОБАКАМ -->
                <li class="nav-item dropdown">
                    <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                       href="#">Собакам</a>
                    <div class="dropdown-menu p-3" style="min-width: 1000px; padding: 28px;">
                        <div class="row g-3">
                            <!-- Харчування -->
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-bag-heart-fill fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Харчування</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=1">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Сухий корм</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=2">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Консервований корм</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=3">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Ласощі</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=4">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Миски та контейнери для дому</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-capsule-pill fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Здоров’я та гігієна</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=5">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Від бліх та кліщів</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=7">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Вітаміни</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=8">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Засоби для догляду</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=9">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Пелюшки та туалети</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-balloon-heart fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Прогулянка та дозвілля</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=10">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Іграшки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=15">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Амуніція</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=16">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Рулетки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=12">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Сумки, переноски</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=13">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Лежаки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="/products?animal=dog&subcategory=17">
                                                <i class="bi bi-chevron-right me-1 text-teal"></i>Одяг</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item"><a class="nav-link" href="/products/sale">Акції</a></li>
                <!-- КОНТАКТИ ЯК ВИПАДАЮЧЕ МЕНЮ -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="contactDropdown" role="button">
                        Контакти
                    </a>
                    <div class="dropdown-menu p-3" aria-labelledby="contactDropdown"
                         style="min-width: 700px; border-radius: 10px;">
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            <div class="col">
                                <div class="bg-light rounded shadow-sm p-3 h-100">
                                    <h6 class="fw-semibold mb-2 text-teal">Консультація:</h6>
                                    <p><i class="bi bi-telephone-fill text-teal me-2"></i><strong>(0800) 351
                                            212</strong></p>
                                    <p><i class="bi bi-telephone-fill text-teal me-2"></i><strong>(044) 310
                                            1100</strong></p>
                                    <p><i class="bi bi-telegram text-teal me-2"></i><strong>(063) 453 00 00</strong>
                                        <span class="text-muted">(Telegram)</span></p>
                                </div>
                            </div>

                            <div class="col">
                                <div class="bg-light rounded shadow-sm p-3 h-100">
                                    <h6 class="fw-semibold mb-2 text-teal">Графік роботи:</h6>
                                    <p><i class="bi bi-clock-fill text-teal me-2"></i>Пн-Пт: з 9 до 20 год</p>
                                    <p><i class="bi bi-clock-fill text-teal me-2"></i>Сб-Нд: з 9 до 18 год</p>
                                </div>
                            </div>

                            <div class="col">
                                <div class="bg-light rounded shadow-sm p-3 h-100">
                                    <h6 class="fw-semibold mb-2 text-teal">Напишіть нам:</h6>
                                    <p>
                                        <i class="bi bi-envelope-fill text-teal me-2"></i><strong>info@petizoo.ua</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>

            <form class="d-flex me-3" role="search" method="get" action="/products">
                <input name="search" class="form-control form-control-sm me-2" type="search" placeholder="Пошук..." aria-label="Search"
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button class="btn btn-outline-success btn-sm" type="submit">🔍</button>
            </form>

            <a href="/cart/index" class="btn btn-outline-secondary position-relative btn-sm me-2">
                <i class="bi bi-cart2"></i> Кошик
                <?php if (($count = $_SESSION['cart_count'] ?? 0) > 0): ?>
                    <span id="cart-badge"
                          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= $count ?>
        </span>
                <?php endif; ?>
            </a>

            <?php if (!\models\Users::IsUserLogged()) : ?>
                <a href="/users/login" class="btn btn-outline-primary btn-sm me-2">Увійти</a>
                <a href="/users/register" class="btn btn-primary btn-sm">Реєстрація</a>
            <?php else: ?>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="fw-semibold text-dark">
            <i class="bi bi-person-circle me-1 text-primary"></i>
            <?= $_SESSION['user']['login'] ?>
        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if ($_SESSION['user']['login'] === 'admin@petizoo.ua'): ?>
                            <li><a class="dropdown-item text-danger fw-semibold" href="/admin/dashboard">
                                    <i class="bi bi-shield-lock me-2 text-danger"></i>Панель адміністратора</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="/profile/settings"><i class="bi bi-gear me-2"></i>Налаштування</a></li>
                            <li><a class="dropdown-item" href="/profile/orders"><i class="bi bi-receipt me-2"></i>Мої замовлення</a></li>
                            <li><a class="dropdown-item" href="/profile/favorites"><i class="bi bi-heart me-2"></i>Улюблені товари</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/users/logout"><i class="bi bi-box-arrow-right me-2"></i>Вийти</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
</div>
<main class="container pt-0 bg-white p-4 rounded shadow-sm my-4">
    <h1 class="mb-4"><?= $Title ?></h1>
    <?= $Content ?>
</main>

<footer class="footer-custom py-4 mt-auto border-top">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
            <div class="col mb-3">
                <h6 class="fw-bold">Petizoo</h6>
                <p>© 2025. Усі права захищено.</p>
            </div>
            <div class="col mb-3">
                <h6>Навігація</h6>
                <ul class="list-unstyled">
                    <li><a href="/">Головна</a></li>
                    <li><a href="/products/index">Каталог</a></li>
                    <li><a href="/products/sale">Акції</a></li>
                </ul>
            </div>
            <div class="col mb-3">
                <h6>Допомога</h6>
                <ul class="list-unstyled">
                    <li><a href="/info/delivery">Доставка</a></li>
                    <li><a href="/info/payment">Оплата</a></li>
                    <li><a href="/info/return">Повернення</a></li>
                </ul>
            </div>
            <div class="col mb-3">
                <h6>Ми у соцмережах</h6>
                <a href="#" class="me-2">🐾 Facebook</a><br/>
                <a href="#">📷 Instagram</a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
