<div class="head"><a href="{$home}/blogs">Блоги</a> / <a href="{$home}/blogs/{$row.refid}">{$row.namecat|esc|escape}</a> / <a href="{$home}/blogs/{$row.refid}/{$row.id}-{$row.translate}">{$row.name|esc|escape}</a> / {$title}
    <span class="pull-right">
        <a href="{$home}/profile/blog/add">Добавить пост</a>
    </span> 
</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
    <form action="{$url}" method="post" class="fon">
        <p>Текст сообщения: <br/>
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
        </p>
        <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
    </form>
</div>
<div class="menu"><a href="{$home}/blogs/comments/{$row.id_post}"><i class="fa fa-angle-left"></i> Вернуться к комментариям</a></div>