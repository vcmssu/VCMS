<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$rows.id}">{$rows.name|esc}</a> / {$title}</div>
<div class="fon">
    {$text|escape|esc|nl2br}
<form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данный пост?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$rows.id}/{$tema.id}?page={$starts}#{$row.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|esc}</a></div> 