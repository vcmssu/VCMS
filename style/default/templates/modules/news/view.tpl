<div class="head">
    <a href="{$home}/news">Новости</a> / 
    {$title}
</div>
<div class="fon">
    {if $user.level > 29}
        <div class="breadcrumb">
            <a href="{$home}/news/edit/{$row.id}">Редактировать</a> / 
            {if $user.level > 30}
                <a href="{$home}/news/del/{$row.id}">Удалить</a> / 
            {/if}
            {if $user.level > 40}
                <a href="{$home}/news/mail/{$row.id}">Произвести рассылку</a> / 
            {/if}
            <a href="{$home}/news/all">Все новости</a> / 
            <a href="{$home}/news/add">Добавить новость</a>
        </div>
    {/if}
    <h1>{$title}</h1>
    {$text|escape|esc|nl2br}
    {if $row.comments == 1}<p class="margin-top-10 menu"><a href="{$home}/news/comments/{$row.id}">Комментарии ({$count|number})</a></p>{/if}
</div>