<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$rows.id}">{$rows.name|escape|esc}</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}  
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Текст сообщения:<br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
        </p>
        {if $arrayrowfile}
            <p>Выберите файлы для удаления:</p>
            {foreach from=$arrayrowfile item=file}
                <label><input type="checkbox" value="{$file.id}" name="del[]"/> {$file.file|escape|esc}</label><br/>
                {/foreach}
            {/if}
        <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
    </form>
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$rows.id}/{$tema.id}?page={$starts}#{$row.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|escape|esc}</a></div> 