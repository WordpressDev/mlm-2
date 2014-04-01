<form enctype="multipart/form-data" method="POST" action="/profile" name="profile" id="profile">
    <div>
        ФИО
        <input type="text" id="name" name="name" value="<?=$view['data']['name']?>">
        <span class="error"><?=$view['errors']['name']?></span>
    </div>
    <div>
        Email
        <input type="text" id="email" name="email" value="<?=$view['data']['email']?>">
        <span class="error"><?=$view['errors']['email']?></span>
    </div>
    <div>
        Пароль
        <input type="password" id="password" name="password" value="<?=$view['data']['password']?>">
        <span class="error"></span>
    </div>
    <div>
        Город
        <input type="text" id="city" name="city" value="<?=$view['data']['city']?>">
        <span class="error"></span>
    </div>
    <div>
        Аватар
        <input type="file" id="avatar" name="avatar">
        <span class="error"><?=$view['errors']['avatar']?></span>
        <? if($view['avatar']): ?>
            <img src="<?=$view['avatar']?>" width="100"/>
        <? endif ?>
    </div>
    <div>
        О себе
        <textarea name="about" id="about"><?=$view['data']['about']?></textarea>
        <span class="error"></span>
    </div>
    <div>
        <input type="submit" value="Сохранить">
    </div>
</form>