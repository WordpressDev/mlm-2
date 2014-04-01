<? if(!empty($view['news'])): ?>
    <? foreach($view['news'] as $new): ?>
        <div class="article">
            <div class="title">
                <a href="/news/<?=$new['id']?>"><?=$new['title']?></a>
            </div>
            <div class="date"><?=date('H:i j/m/Y', strtotime($new['date']))?></div>
            <div class="text"><?=$new['text']?></div>
        </div>
        <hr>
    <? endforeach ?>
<? elseif (!empty($view['one'])): ?>
    <div class="article">
        <div class="title" style="font-weight: bold">
            <?=$view['one']['title']?>
        </div>
        <div class="date"><?=date('H:i j/m/Y', strtotime($view['one']['date']))?></div>
        <div class="text"><?=$view['one']['text']?></div>
    </div>
<? endif ?>
 