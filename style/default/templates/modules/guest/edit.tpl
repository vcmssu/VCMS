<div class="head"><a href="{$home}/guest">Гостевая</a> / {$title}</div>
<div class="fon">
{if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
<form action="{$url}" method="post" class="links">
    <p>Текст сообщения: <br/>
        {include file='system/panel.tpl'} 
        {$smarty.capture.edit_comments}
    </p>
    <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
</form>
</div>