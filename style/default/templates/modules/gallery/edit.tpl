<div class="head"><a href="{$home}/gallery">Фотогалерея</a> / <a href="{$home}/gallery/{$row.id_gallery}">{$row.namealbum|escape|esc}</a> / <a href="{$home}/gallery/{$row.id_gallery}/{$row.id}">{$row.name|escape|esc}</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font><label>Название фотографии:</label> <br/> <input type="text" class="form-control" name="name" value="{$row.name|escape|esc}"/></p>
        <p><label>Выбрать новую фотографию:</label> <br/> <input type="file" class="form-control" name="file"/></p>
        <p><label>Описание фотографии:</label><br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>