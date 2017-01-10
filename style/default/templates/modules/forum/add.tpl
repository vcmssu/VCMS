<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|esc}</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Название темы: <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
        <p><font color="red">*</font>Содержание темы:<br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.add_comments}
        </p>
        {if $setup.captcha_add_theme == 1}
            {include file='system/captcha.tpl'}
        {/if}
        {$smarty.capture.add_file}
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>