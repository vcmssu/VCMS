<div class="head">
    <a href="{$home}/news">Новости</a> / <a href="{$home}/news/{$row.id}-{$row.translate}">{$row.name|esc}</a> / 
    {$title}
</div>
<div class="fon">
    <div class="breadcrumb">
        <a href="{$home}/news/all">Все новости</a> / 
        <a href="{$home}/news/add">Добавить новость</a>
    </div>
    {include file='system/error.tpl'}
    {$smarty.capture.del_comments} 
</div>
<div class="menu"><a href="{$home}/news/comments/{$row.id_news}"><i class="fa fa-angle-left"></i> Вернуться к комментариям</a></div>