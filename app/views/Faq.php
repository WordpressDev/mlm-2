<? if(!empty($view['data'])): ?>
    <? foreach($view['data'] as $faq): ?>
        <div class="question" style="font-weight: bold"><?=$faq['question']['text']?></div>
        <div class="answer"><?=$faq['answer']['text']?></div>
        <hr>
    <? endforeach ?>
<? endif ?>
 