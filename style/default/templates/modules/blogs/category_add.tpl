<div class="head"><a href="{$home}/blogs">Блоги</a> / <a href="{$home}/blogs/category">Категории</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font><label>Название категории:</label> <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
        <p>
            {include file='system/seo.tpl'}
            {$smarty.capture.add_seo}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>