<div class="head"><a href="{$home}/news">Новости</a> / {$title}</div>
<div class="fon">
{if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
<form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
    <p><font color="red">*</font>Название новости: <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
    <p><font color="red">*</font>Текст новости:<br/> 
        {include file='system/panel.tpl'}
        {$smarty.capture.add_comments}
        {include file='system/seo.tpl'}
        {$smarty.capture.add_seo}
    </p>
    <h3>Дополнительные опции</h3>
    <p><label><input name="comments" type="checkbox" value="1" checked="checked">&nbsp;Комментирование</label></p>
    <p><label><input name="status" type="checkbox" value="1" checked="checked">&nbsp;Опубликовать</label></p>
    <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
</form>
</div>