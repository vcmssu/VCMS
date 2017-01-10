<div class="head"><a href="{$home}/guest">Гостевая</a> / {$title}</div>
<div class="fon">
    <p>{$text|escape|esc|nl2br}</p>
    <form action="{$url}" method="post" class="links">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данное сообщение?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>