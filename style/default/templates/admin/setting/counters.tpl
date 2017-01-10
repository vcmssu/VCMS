<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/setting">{$title}</a> / Счетчики посещаемости</div>
<div class="fon">
    <form action="{$home}{$panel}/setting/counters" method="post" class="fon">
        <textarea name="counters" class="form-control" rows="25"/>{$setup.counters|escape}</textarea><br/>
        <input type="submit" name="submit" value="Сохранить" class="btn btn-primary"><br/><br/>
    </form>
    {if $setup.compress != 3}<div class="alert alert-danger">Включёно сжатие HTML. Перед редактированием его рекомендуется <a href="{$home}{$panel}/setting">выключить</a>.</div>{/if} 
</div>