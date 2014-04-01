<?=Functions::jsTag('jquery.mask', 'jquery/plugins')?>

<?=Functions::jsTag('register')?>

<form method="POST" name="register">
    <div>
        Номер телефона
        <input type="text" id="phone" name="phone">
        <span class="error"></span>
    </div>
    <div>
        ФИО
        <input type="text" id="name" name="name">
        <span class="error"></span>
    </div>
    <div>
        Email
        <input type="text" id="email" name="email">
        <span class="error"></span>
    </div>
    <div>
        Информационный спонсор
        <? if($view['sponsor']): ?>
            <input type="text" id="sponsor" name="sponsor" value="<?=$view['sponsor']?>" disabled>
        <? else: ?>
            <input type="text" id="sponsor" name="sponsor">
        <? endif ?>
        <span class="error"></span>
    </div>
    <div>
        Каптча
        <p><img src="/captcha/?<?php echo session_name()?>=<?php echo session_id()?>"></p>
        <input type="text" id="captcha" name="captcha">
        <span class="error"></span>
    </div>
    <div>
        Пароль
        <input type="password" id="password" name="password">
        <span class="error"></span>
    </div>
    <div>
        С правилами ознакомлен
        <input type="checkbox" id="agreement" name="agreement">
        <span class="error"></span>
    </div>
    <div>
        <input type="submit" id="submit" name="submit" value="Регистрация" disabled>
    </div>
</form>
<div class="blind" style="display: none">
    <div class="layout">
    </div>
    <div class="dialog">
        <form name="confirm-phone" id="confirm-phone" method="POST">
            <div>
                Введите код:
                <input type="text" id="confirm-code" name="confirm-code">
                <span class="error"></span>
            </div>
            <div>
                <input id="confirm-submit" type="submit" value="Подтвердить" disabled>
                <input id="resend-code" type="button" value="Перезапросить код" disabled>
            </div>
        </form>
    </div>
</div>