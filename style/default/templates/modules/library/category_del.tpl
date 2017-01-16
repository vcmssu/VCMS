<div class="head"><a href="{$home}/library">Библиотека</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    <form action="{$url}" method="post" enctype="multipart/form-data" class="links">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данную категорию? Вместе с ней будут удалены вложенные категории и статьи (комментарии к статьям), если они имеются.</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>