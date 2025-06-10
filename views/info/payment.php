<?php // views/info/payment.php ?>

<section class="info-page">
    <h1 class="text-center mb-4 text-primary">&nbsp;💳 Оплата</h1>
    <p class="lead">Ми пропонуємо прості й надійні способи оплати:</p>
    <ul>
        <li>💵 <strong>Наложений платіж</strong> при отриманні</li>
        <li>💳 <strong>Передоплата</strong> на банківську картку (реквізити надсилаються після дзвінка)</li>
    </ul>
    <p>Після оформлення з вами зв'яжеться наш менеджер для підтвердження та надасть реквізити, якщо ви обрали передоплату.</p>
    <p><strong>Ми не приймаємо оплату на сайті</strong>, тільки перевіреними методами після підтвердження замовлення.</p>
</section>

<style>
    .info-page {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 8px 24px rgba(56, 182, 163, 0.12);
        max-width: 850px;
        margin: 50px auto;
        transition: all 0.3s ease-in-out;
    }

    .info-page h1 {
        font-weight: 700;
        font-size: 2.2rem;
        color: #38b6a3;
        text-align: center;
        margin-bottom: 30px;
    }

    .info-page p {
        font-size: 1.05rem;
        color: #444;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .info-page p.lead {
        font-size: 1.15rem;
        font-weight: 500;
        color: #2e2e2e;
        margin-bottom: 1.5rem;
    }

    .info-page ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 1.5rem;
    }

    .info-page ul li {
        font-size: 1.05rem;
        margin-bottom: 10px;
        padding-left: 1.8rem;
        position: relative;
        color: #333;
    }

    .info-page ul li::before {
        content: '✔';
        color: #38b6a3;
        font-weight: bold;
        position: absolute;
        left: 0;
    }
</style>