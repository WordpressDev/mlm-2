<form method="POST" action="/admin/login" name="auth" id="auth">
    <div>
        Логин
        <input type="text" id="login" name="login">
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
    <?=$view['error']?>
</div>