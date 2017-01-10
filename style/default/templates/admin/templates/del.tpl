<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/templates">{$title}</a> / Удаление шаблона {$temp}</div>
<div class="fon">
    <form action="{$home}{$panel}/templates/del/{$temp}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данный шаблон?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>