<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|escape|esc}</a> / {$title}</div>
<div class="fon">
    {include file='system/user.tpl'}
    {$smarty.capture.forum}
    {$text|escape|esc|nl2br}
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}?page={$starts}#{$rows.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|escape|esc}</a></div> 