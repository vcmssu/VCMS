<div class="head"><a href="{$home}/profile">Мой кабинет</a> / <a href="{$home}/profile/bookmark">Закладки</a> / {$title}</div>
<div class="fon">
{if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
<form action="{$url}" method="post" class="fon" enctype="multipart/form-data">
    <p>Название: <br/><input type="text" name="name" value="{$row.name|escape|esc}" class="form-control"/></p>
    <p>Ссылка: <br/><textarea name="url" class="form-control">{$row.url|escape|esc}</textarea></p>
    <p><input type="submit" name="ok" value="Сохранить" class="btn btn-primary"></p>
</form>
</div>