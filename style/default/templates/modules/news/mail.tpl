<div class="head"><a href="{$home}/news">Новости</a> / <a href="{$home}/news/{$row.id}-{$row.translate}">{$row.name|esc}</a> / {$title}</div>
<div class="fon">
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <div class="alert alert-info">Вы уверены, что хотите произвести рассылку?</div>
        <p><label>Подписчиков в базе для рассылки: {$count|number}{if $row.timemail} Рассылка произведена: {$row.timemail|times}{/if}</label></p>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
</div>