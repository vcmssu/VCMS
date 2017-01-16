<div class="head"><a href="{$home}/profile">Мой кабинет</a> / <a href="{$home}/profile/library">Статьи</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Название статьи: <br/> <input type="text" class="form-control" name="name" value="{$row.name|escape|esc}"/></p>
        <p>Автор: <br/> <input type="text" class="form-control" name="autor" value="{$row.autor|escape|esc}"/></p>
        <p><font color="red">*</font>Содержание статьи:<br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>