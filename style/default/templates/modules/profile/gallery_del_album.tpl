<div class="head"><a href="{$home}/profile">Мой кабинет</a> / <a href="{$home}/profile/gallery">Фотоальбомы</a> / <a href="{$home}/profile/gallery/{$row.id}">{$row.name|escape|esc}</a> / {$title}</div>
<div class="fon">
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данный альбом?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>