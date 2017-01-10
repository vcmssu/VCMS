{if $count > 0}
    {foreach from=$arrayrow item=rows}
        <div class="list">
            <a href="{$home}/blogs/{$rows.refid}/{$rows.id}-{$rows.translate}" class="title" title="Просмотреть">{$rows.name|esc|escape}</a> ({$rows.time|times})
            <p class="line">Автор: <a href="{$home}/id{$rows.id_user}">{$rows.login|esc|escape}</a></p>
            <p class="line">Категория: <a href="{$home}/blogs/{$rows.refid}">{$rows.namecat|esc|escape}</a></p>
            <p class="line"><a href="{$home}/blogs/comments/{$rows.id}">Комментарии ({$rows.count|number})</a></p>
            {if $user.level > 30}
                <span class="breadcrumb">
                    <a href="{$home}/blogs/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                    <a href="{$home}/blogs/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                </span>
            {/if}
        </div>
    {/foreach}
{else}
    <div class="alert alert-danger">Постов ещё нет...</div>
{/if}
{*постраничка*} 
{if $count > $message}
    <div class="paging_bootstrap pagination">{$pagenav}</div>
{/if}