<?=Functions::jsTag('admin/news')?>
<div id="new">
    <input type="button" id="create-new" value="Добавить новость">
    <form name="new" method="POST" action="/admin/news/new" style="display: none">
        <div>
            Заголовок:
            <input type="text" name="title" value="">
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
<? if(!empty($view['news'])): ?>
    <? foreach($view['news'] as $new): ?>
        <div class="article">
            <div class="show-article">
                <div class="title"><?=$new['title']?></div>
                <div class="date"><?=date('H:i j/m/Y', strtotime($new['date']))?></div>
                <div class="text"><?=$new['text']?></div>
                <div class="controls">
                    <a href="#" class="edit">Редактировать</a>
                    <a href="#" class="delete">Удалить</a>
                </div>
            </div>
            <div style="display: none" class="edit-article">
                <form method="POST" action="/admin/news/edit/<?=$new['id']?>">
                    <div>
                        Заголовок:
                        <input type="text" name="title" value="<?=$new['title']?>">
                    </div>
                    <div>
                        Текст:
                        <textarea name="text"><?=$new['text']?></textarea>
                    </div>
                    <div>
                        <input type="submit" value="Сохранить">
                        <input type="reset" value="Отменить">
                    </div>
                </form>
                <form method="post" action="/admin/news/delete/<?=$new['id']?>" name="delete" style="display: none">
                </form>
            </div>
        </div>
        <hr>
    <? endforeach ?>
<? endif ?>
 