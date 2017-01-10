<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/blog">{$title}</a> / <a href="{$home}{$panel}/blog/category">Категории</a> / Редактирование категории {$row.name|esc|escape}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$home}{$panel}/blog/category/edit/{$row.id}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font><label>Название категории:</label> <br/> <input type="text" class="form-control" name="name" value="{$row.name|esc|escape}"/></p>
        <p>
            {include file='system/seo.tpl'}
            {$smarty.capture.edit_seo}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>