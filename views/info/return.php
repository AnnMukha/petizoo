<?php // views/info/return.php ?>

<section class="info-page">
    <h1 class="text-center mb-4 text-danger">&nbsp;🔄 Повернення</h1>
    <p class="lead">Ми розуміємо, що іноді щось може піти не так. Ви можете повернути товар у таких випадках:</p>
    <ul>
        <li>Товар не підійшов вашому улюбленцю</li>
        <li>Товар пошкоджений</li>
        <li>Невідповідність опису</li>
    </ul>

    <h5>⏲ Строк</h5>
    <p>Ви маєте <strong>14 днів</strong>, щоб подати запит на повернення.</p>

    <h5>📧 Як це зробити?</h5>
    <ol>
        <li>Напишіть нам на <strong>support@petizoo.ua</strong></li>
        <li>Вкажіть номер замовлення, проблему, фото (якщо є)</li>
        <li>Очікуйте дзвінка менеджера</li>
    </ol>

    <p>Після погодження &mdash; повернення грошей протягом 3&ndash;5 робочих днів на картку.</p>
</section>

<style>
    .info-page {
        background-color: #fff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 8px 24px rgba(255, 91, 91, 0.12);
        max-width: 850px;
        margin: 50px auto;
        transition: all 0.3s ease-in-out;
    }

    .info-page h1 {
        font-weight: 700;
        font-size: 2.2rem;
        color: #dc3545;
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

    .info-page ul,
    .info-page ol {
        padding-left: 1.2rem;
        margin-bottom: 1.5rem;
    }

    .info-page ul li,
    .info-page ol li {
        font-size: 1.05rem;
        margin-bottom: 10px;
        color: #333;
    }

    .info-page h5 {
        font-size: 1.2rem;
        color: #dc3545;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
    }
</style>
