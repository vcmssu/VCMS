<div class="head"><a href="{$home}/download">Загрузки</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    <form action="{$url}" method="post" enctype="multipart/form-data" class="links">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данный файл?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>
<div class="menu"><a href="{$home}/download/{$row.id}-{$row.translate}"><i class="fa fa-angle-left"></i> К файлу {$row.name|esc}</a></div>        