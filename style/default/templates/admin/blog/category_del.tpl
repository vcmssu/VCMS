<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/blog">{$title}</a> / <a href="{$home}{$panel}/blog/category">Категории</a> / Удаление категории {$row.name|esc|escape}</div>
<div class="fon">
    <form action="{$home}{$panel}/blog/category/del/{$row.id}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данную категорию? Вместе с ней будут удалены и все записи, которые в ней содержатся.</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>