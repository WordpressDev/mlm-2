<?=Functions::jsTag('admin/faq')?>
<div id="new">
    <input type="button" id="create-new" value="Добавить FAQ">
    <form name="new" method="POST" action="/admin/faq/new" style="display: none">
        <div>
            Вопрос:
            <input type="text" name="question" value="">
        </div>
        <div>
            Ответ:
            <input type="text" name="answer" value="">
        </div>
        <div>
            <input type="submit" value="Сохранить">
            <input type="reset" value="Отменить">
        </div>
    </form>
</div>
<? if(!empty($view['data'])): ?>
    <? foreach($view['data'] as $faq): ?>
        <div class="faq">
            <div class="show-faq">
                <div class="question" style="font-weight: bold">
                    <?=$faq['question']['text']?>
                </div>
                <div class="answer">
                    <?=$faq['answer']['text']?>
                </div>
                <div class="controls">
                    <a href="#" class="edit">Редактировать</a>
                    <a href="#" class="delete">Удалить</a>
                </div>
            </div>
            <div style="display: none" class="edit-faq">
                <form method="POST" action="/admin/faq/edit/<?=$faq['question']['id']?>">
                    <div>
                        Вопрос:
                        <input type="text" name="question" value="<?=$faq['question']['text']?>">
                    </div>
                    <div>
                        Ответ:
                        <input type="text" name="answer" value="<?=$faq['answer']['text']?>">
                    </div>
                    <div>
                        <input type="submit" value="Сохранить">
                        <input type="reset" value="Отменить">
                    </div>
                </form>
                <form method="post" action="/admin/faq/delete/<?=$faq['question']['id']?>" name="delete" style="display: none">
                </form>
            </div>
            <hr>
        </div>
    <? endforeach ?>
<? endif ?>