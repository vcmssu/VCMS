<div class="head"><a href="{$home}/news">Новости</a> / <a href="{$home}/news/{$row.id}-{$row.translate}">{$row.name|esc}</a> / {$title}</div>
<div class="fon">
    {$text|escape|esc|nl2br}
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данную новость?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>