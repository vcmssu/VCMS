<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}<span class="pull-right"><a href="{$home}/profile/blog/add">Добавить запись</a></span></div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=rows}
            <div class="list">
                <a href="{$home}/blogs/{$rows.refid}/{$rows.id}-{$rows.translate}" class="title" title="Просмотреть">{$rows.name|esc|escape}</a> ({$rows.time|times})
                <p class="line"><a href="{$home}/blogs/comments/{$rows.id}">Комментарии ({$rows.count|number})</a></p>
                <span class="breadcrumb">
                    <a href="{$home}/profile/blog/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                    <a href="{$home}/profile/blog/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                </span>
            </div>
        {/foreach}
    {else}
        <div class="alert alert-danger">Записей ещё нет...</div>
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if} 
</div>