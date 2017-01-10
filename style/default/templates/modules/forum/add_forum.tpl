<div class="head"><a href="{$home}/forum">Форум</a>{if $rows.id} / <a href="{$home}/forum/{$rows.id}">{$rows.name|esc}</a>{/if} / {$title}</div>
<div class="fon">
{if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
<form action="{$home}/forum/setup/add{if $rows.id}/{$rows.id}{/if}" method="post" enctype="multipart/form-data" class="fon">
    {if $rows.id == 0}<p><font color="red">*</font>Доступ: <br/> 
        <select name="type" class="form-control">
            <option value="0">Всем</option>
            <option value="1">Только авторизованным</option>
            <option value="2">Только администрации</option>
        </select>
    </p>{/if}
    <p><font color="red">*</font>Название раздела: <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
    <p>Описание раздела:<br/> 
        {include file='system/panel.tpl'}
        {$smarty.capture.add_comments}
        {include file='system/seo.tpl'}
        {$smarty.capture.add_seo}
    </p>
    <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
</form> 
</div>