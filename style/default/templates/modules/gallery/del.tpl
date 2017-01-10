<div class="head"><a href="{$home}/gallery">Фотогалерея</a> / <a href="{$home}/gallery/{$row.id_gallery}">{$row.namealbum|escape|esc}</a> / <a href="{$home}/gallery/{$row.id_gallery}/{$row.id}">{$row.name|escape|esc}</a> / {$title}</div>
<div class="fon">
    <img src="{$home}/files/user/{$row.id_user}/gallery/{$row.id_gallery}/small-{$row.photo}"/>
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данную фотографию?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>