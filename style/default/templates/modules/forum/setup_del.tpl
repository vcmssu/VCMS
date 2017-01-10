<div class="head"><a href="{$home}/forum">Форум</a>{if $forum.id} / <a href="{$home}/forum/{$forum.id}">{$forum.name|esc}</a>{/if} / {$title}</div>
<div class="fon">
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данный раздел?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>