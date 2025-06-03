<?php
/** @var string $Title */
/** @var string $Content */
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
    </style>
</head>
<body>
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
                    <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                       href="#">Котам</a>
                    <div class="dropdown-menu p-3" style="min-width: 1000px; padding: 28px;">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-bag-heart-fill fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Харчування</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Сухий корм</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Консервований
                                                корм</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Ласощі</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Миски та
                                                контейнери для дому</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-capsule-pill fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Здоров'я та гігієна</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Від бліх та
                                                кліщів</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Від кліщів</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Вітаміни</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Засоби для
                                                догляду</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Пелюшки та
                                                туалети</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-balloon-heart fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Прогулянка та дозвілля</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Іграшки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Кігтеточки</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Сумки, переноски</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Лежаки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Нашийники,
                                                довідки, шлеї</a></li>
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
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-bag-heart-fill fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Харчування</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Сухий корм</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Консерви та
                                                вологий корм</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Ласощі</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Миски та
                                                контейнери для дому</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-capsule-pill fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Здоров'я та гігієна</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Від бліх та
                                                кліщів</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Від кліщів</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Вітаміни</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Засоби для
                                                догляду</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Пелюшки та
                                                туалети</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded shadow-sm h-100">
                                    <div class="text-center"><i class="bi bi-balloon-heart fs-2 text-teal"></i>
                                        <div class="fw-bold mt-2">Прогулянка та дозвілля</div>
                                    </div>
                                    <ul class="list-unstyled mt-2 ps-3 small">
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Іграшки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Амуніція</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Рулетки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Сумки, переноски</a>
                                        </li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Лежаки</a></li>
                                        <li><a class="text-decoration-none text-dark" href="#"><i
                                                        class="bi bi-chevron-right me-1 text-teal"></i>Одяг</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item"><a class="nav-link" href="/product/sale">Акції</a></li>
                <!-- КОНТАКТИ ЯК ВИПАДАЮЧЕ МЕНЮ -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="contactDropdown" role="button">
                        Контакти
                    </a>
                    <div class="dropdown-menu p-3" aria-labelledby="contactDropdown"
                         style="min-width: 700px; border-radius: 10px;">
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            <!-- Телефони -->
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

                            <!-- Графік роботи -->
                            <div class="col">
                                <div class="bg-light rounded shadow-sm p-3 h-100">
                                    <h6 class="fw-semibold mb-2 text-teal">Графік роботи:</h6>
                                    <p><i class="bi bi-clock-fill text-teal me-2"></i>Пн-Пт: з 9 до 20 год</p>
                                    <p><i class="bi bi-clock-fill text-teal me-2"></i>Сб-Нд: з 9 до 18 год</p>
                                </div>
                            </div>

                            <!-- Email -->
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

            <form class="d-flex me-3" role="search">
                <input class="form-control form-control-sm me-2" type="search" placeholder="Пошук..."
                       aria-label="Search"/>
                <button class="btn btn-outline-success btn-sm" type="submit">🔍</button>
            </form>
            <a href="/cart" class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-cart3"></i> Кошик
            </a>
            <?php if (!\models\Users::IsUserLogged()) : ?>
                <a href="/users/login" class="btn btn-outline-primary btn-sm me-2">Увійти</a>
                <a href="/users/register" class="btn btn-primary btn-sm">Реєстрація</a>
            <?php else: ?>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                       data-bs-toggle="dropdown">
                        <img src="https://github.com/mdo.png" alt="avatar" width="32" height="32"
                             class="rounded-circle me-2"/>
                        <span>Профіль</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Налаштування</a></li>
                        <li><a class="dropdown-item" href="#">Мої замовлення</a></li>
                        <li>
                            <hr class="dropdown-divider"/>
                        </li>
                        <li><a class="dropdown-item" href="/users/logout">Вийти</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

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
                    <li><a href="/product/catalog">Каталог</a></li>
                    <li><a href="/product/sale">Акції</a></li>
                </ul>
            </div>
            <div class="col mb-3">
                <h6>Допомога</h6>
                <ul class="list-unstyled">
                    <li><a href="#">Доставка</a></li>
                    <li><a href="#">Оплата</a></li>
                    <li><a href="#">Повернення</a></li>
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
