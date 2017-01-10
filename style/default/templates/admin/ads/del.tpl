<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/ads">{$title}</a> / Редактирование рекламы {$row.link|esc}</div>
<div class="fon">
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данную рекламную ссылку?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>