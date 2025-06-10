<?php // views/info/delivery.php ?>

<section class="info-page">
    <h1 class="text-center mb-4 text-success">🌿 Доставка</h1>
    <p class="lead">Ми дбаємо, щоб кожне замовлення прибуло швидко, вчасно та безпечно. Ви можете обрати зручний спосіб доставки:</p>

    <ul>
        <li><strong>🚚 Кур'єром по місту</strong> &mdash; зручна доставка до дверей</li>
        <li><strong>🏦 Нова Пошта / Укрпошта</strong> &mdash; доставка по всій Україні</li>
    </ul>

    <h5 class="mt-4">⏰ Терміни</h5>
    <p>1&ndash;2 дні по місту, 2&ndash;4 дні по Україні.</p>

    <h5>💸 Тарифи</h5>
    <ul>
        <li>Безкоштовно від <strong>500 грн</strong></li>
        <li>Інакше &mdash; за тарифами перевізника</li>
    </ul>
    <p>Після оформлення з вами зв'яжеться менеджер для уточнення деталей — відділення, дата, час тощо.</p>
</section>

<style>
    .info-page {
        background-color: #f8fff9;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 8px 24px rgba(56, 182, 114, 0.12);
        max-width: 850px;
        margin: 50px auto;
        transition: all 0.3s ease-in-out;
    }

    .info-page h1 {
        font-weight: 700;
        font-size: 2.2rem;
        color: #28a745;
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
        color: #28a745;
        font-weight: bold;
        position: absolute;
        left: 0;
    }

    .info-page h5 {
        font-size: 1.2rem;
        color: #218838;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
    }
</style>