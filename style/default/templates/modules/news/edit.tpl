<div class="head"><a href="{$home}/news">Новости</a> / <a href="{$home}/news/{$row.id}-{$row.translate}">{$row.name|esc}</a> / {$title}</div>
<div class="fon">
{if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
<form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
    <p><font color="red">*</font>Название новости: <br/> <input type="text" class="form-control" name="name" value="{$row.name|escape|esc}"/></p>
    <p><font color="red">*</font>Текст новости:<br/> 
        {include file='system/panel.tpl'}
        {$smarty.capture.edit_comments}
    </p>
    <h3>Дополнительные опции</h3>
    <p><label><input name="comments" type="checkbox" value="1"{if $row.comments == 1} checked="checked"{/if}>&nbsp;Комментирование</label></p>
    <p><label><input name="status" type="checkbox" value="1"{if $row.status == 1} checked="checked"{/if}>&nbsp;Опубликовать</label></p>
    {include file='system/seo.tpl'}
    {$smarty.capture.edit_seo}
    <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
</form>
</div>