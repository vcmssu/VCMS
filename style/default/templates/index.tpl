{if $news.id}
    <div class="pod">
        <div class="head"><a href="{$home}/news" class="link"><i class="fa fa-feed"></i> Новости ({$news.time|times})</a></div> 
        <div class="text">
            <p>{$text|esc|truncate:220|strip_tags:false|nl2br}</p>
            <a href="{$home}/news/{$news.id}-{$news.translate}">Подробнее...</a>
            {if $news.comments == 1}<a href="{$home}/news/comments/{$news.id}">Комментарии ({$news.count|number})</a>{/if}
        </div>
    </div>
{else}
    <div class="head"><a href="{$home}/news"><i class="fa fa-feed"></i> Новости</a></div>   
{/if}
<div class="pod">
    <div class="head"> Полезное</div>
    <div class="menu"><a href="{$home}/download"><i class="fa fa-download"></i> Загрузки ({$download|number}{if $downloadnew > 0} <font color="red">+{$downloadnew|number}</font>{/if})</a></div>
</div>
{if $lastthems}
    <div class="pod visible-xs visible-sm">
        <div class="head">Новые темы</div>
        {foreach from=$lastthems item=rows key=k}
            {math equation="max(0, z - ((( z % y) == 0) ? y : ( z % y)))" z=$rows.countpost y=$message assign="starts"}
            <div class="menu">
                <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id}">{$rows.name|escape|esc} ({$rows.countpost})</a> 
                <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id}?page={$starts}#{$rows.id_post_last}" title="Последнее сообщение"><i class="fa fa-angle-double-right"></i></a>
                <a href="{$home}/id{$rows.id_user_last}">{$rows.login|escape|esc}</a>
                <span>{$rows.time|times}</span>
            </div>
        {/foreach}
    </div>
{/if}
<div class="pod">
    <div class="head">Общение</div>
    <div class="menu"><a href="{$home}/guest"><i class="fa fa-pencil-square"></i> Гостевая ({$guest|number})</a></div>
    <div class="menu"><a href="{$home}/blogs"><i class="fa fa-sticky-note"></i> Блоги ({$blog|number})</a></div>
    <div class="menu"><a href="{$home}/forum"><i class="fa fa-comments"></i> Форум ({$tema|number} / {$post|number})</a></div>
</div>
<div class="pod">
    <div class="head">Сообщество</div>
    <div class="menu"><a href="{$home}/users"><i class="fa fa-users"></i> Пользователи ({$users|number})</a></div>
    <div class="menu"><a href="{$home}/gallery"><i class="fa fa-picture-o"></i> Фотогалерея ({$gallery|number} / {$gallery_photo|number})</a></div>
</div>