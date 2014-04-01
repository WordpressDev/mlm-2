<?=Functions::jsTag('login')?>

<form method="POST" action="/login" name="auth" id="auth">
    <div>
        Номер телефона
        <input type="text" id="phone" name="phone">
        <span class="error"></span>
    </div>
    <div>
        Пароль
        <input type="password" id="password" name="password">
        <span class="error"></span>
    </div>
    <div>
        <input type="submit" value="Войти">
    </div>
</form>
<div>
    <?=$view['errors']?>
</div>