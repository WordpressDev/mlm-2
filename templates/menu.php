<ul>
    <li>
        <a href="/news/">
            Новости
            <? if($_SESSION['user']['fresh_news'] > 0): ?>
                (<?=$_SESSION['user']['fresh_news']?>)
            <? endif ?>
        </a>
    <li><a href="/static/about">О системе</a>
    <li><a href="/faq">FAQ</a>
    <li><a href="/payment">Оплата</a>
    <li><a href="/profile">Профиль</a>
    <li>ББ
    <li><a href="/struct">Структура</a>
    <li><a href="/logout">Выход</a>
</ul>
 