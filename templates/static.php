<?=Functions::jsTag('admin/static')?>
    <div id="new">
        <input type="button" id="create-new" value="Добавить страницу">
        <form name="new" method="POST" action="/admin/static/new" style="display: none">
            <div>
                Название:
                <input type="text" name="name" value="">
            </div>
            <div>
                URL:
                <input type="text" name="url" value="">
            </div>
            <div>
                Текст:
                <textarea name="text"></textarea>
            </div>
            <div>
                <input type="submit" value="Сохранить">
                <input type="reset" value="Отменить">
            </div>
        </form>
    </div>
<? if(!empty($view['data'])): ?>
    <? foreach($view['data'] as $static): ?>
        <div class="static">
            <div class="show-static">
                <div class="static-name" style="font-weight: bold">
                    <?=$static['name']?> / <?=$static['url']?>
                </div>
                <div class="static-text">
                    <?=$static['text']?>
                </div>
                <div class="controls">
                    <a href="#" class="edit">Редактировать</a>
                    <a href="#" class="delete">Удалить</a>
                </div>
            </div>
            <div style="display: none" class="edit-static">
                <form method="POST" action="/admin/static/edit/<?=$static['id']?>">
                    <div>
                        Название:
                        <input type="text" name="name" value="<?=$static['name']?>">
                    </div>
                    <div>
                        URL:
                        <input type="text" name="url" value="<?=$static['url']?>">
                    </div>
                    <div>
                        Текст:
                        <textarea name="text"><?=$static['text']?></textarea>
                    </div>
                    <div>
                        <input type="submit" value="Сохранить">
                        <input type="reset" value="Отменить">
                    </div>
                </form>
                <form method="post" action="/admin/static/delete/<?=$static['id']?>" name="delete" style="display: none">
                </form>
            </div>
            <hr>
        </div>
    <? endforeach ?>
<? endif ?>