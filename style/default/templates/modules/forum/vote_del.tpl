<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|escape|esc}</a> / {$title|escape}</div>
<div class="fon">
    {if $tema.countvote == 1}
        <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
            <div class="alert alert-danger">Вы уверены, что хотите удалить данное голосование?</div>
            <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
        </form>
    {else}
        <div class="alert alert-danger">Прежде чем удалять голосование сначала его <a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/vote">создайте</a>!</div>
    {/if}
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|escape|esc}</a></div> 