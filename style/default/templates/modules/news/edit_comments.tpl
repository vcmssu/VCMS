<div class="head">
    <a href="{$home}/news">Новости</a> / <a href="{$home}/news/{$row.id}-{$row.translate}">{$row.name|esc}</a> / 
    {$title}  
</div>
<div class="breadcrumb">
    <a href="{$home}/news/all">Все новости</a> / 
    <a href="{$home}/news/add">Добавить новость</a>
</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
    <form action="{$url}" method="post" class="fon">
        <p>Текст сообщения: <br/>
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
        </p>
        <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
    </form>
</div>
<div class="menu"><a href="{$home}/news/comments/{$row.id_news}"><i class="fa fa-angle-left"></i> Вернуться к комментариям</a></div>