<div class="head"><a href="{$home}/blogs">Блоги</a> / <a href="{$home}/blogs/{$row.refid}">{$row.namecat|esc|escape}</a> / <a href="{$home}/blogs/{$row.refid}/{$row.id}-{$row.translate}">{$row.name|esc|escape}</a> / {$title}
    <span class="pull-right">
        <a href="{$home}/profile/blog/add">Добавить пост</a>
    </span> 
</div>
<div class="fon">
    {include file='system/error.tpl'}
    {$smarty.capture.del_comments} 
</div>