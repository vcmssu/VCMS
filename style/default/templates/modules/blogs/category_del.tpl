<div class="head"><a href="{$home}/blogs">Блоги</a> / <a href="{$home}/blogs/category">Категории</a> / {$title}</div>
<div class="fon">
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данную категорию? Вместе с ней будут удалены и все записи, которые в ней содержатся.</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>