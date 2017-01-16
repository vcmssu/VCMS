<div class="head"><a href="{$home}/blogs">Блоги</a> / <a href="{$home}/blogs/{$row.refid}">{$row.namecat|escape|esc}</a> / {$title}</div>
<div class="fon">
    {if $user.level > 30}
        <div class="breadcrumb">
            <a href="{$home}/blogs/edit/{$row.id}" title="Редактировать">Редактировать</a> | 
            <a href="{$home}/blogs/del/{$row.id}" title="Удалить">Удалить</a>
            {if $user.level == 100}
                | <a href="{$home}/blogs/category/add">Создать категорию</a>
            {/if}
        </div>
    {/if}
    {if $user.id}
        <div class="breadcrumb">
            <a href="{$home}/profile/blog/add">Добавить пост</a>
        </div>  
    {/if}
    <div class="breadcrumb">
        Автор: <a href="{$home}/id{$row.id_user}">{$row.login|escape|esc}</a> | Дата: {$row.time|times} | Просмотров: {$row.views|number}
    </div>
    <h1>{$title}</h1>
    {$text|escape|esc|nl2br}
    {*постраничка*} 
    {if $count > 1}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if} 
    <p class="margin-top-10 menu"><a href="{$home}/blogs/comments/{$row.id}">Комментарии ({$row.count|number})</a></p>
</div>