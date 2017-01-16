<div class="head"><a href="{$home}/library">Библиотека</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / <a href="{$home}/library/{$row.id_file}-{$row.translate}">{$row.name|esc}</a> / {$title}</div>
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
<div class="menu"><a href="{$home}/library/comments/{$row.refid}"><i class="fa fa-angle-left"></i> Вернуться к комментариям</a></div> 