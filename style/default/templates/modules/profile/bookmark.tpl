<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=row}
            <div class="list" id="{$row.id}">
                <a href="{$row.url|esc}">{$row.name|escape|esc}</a> ({$row.time|times})
                <span class="pull-right">
                    <a href="{$home}/profile/bookmark/edit/{$row.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                    <a href="{$home}/profile/bookmark/del/{$row.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                </span>
            </div>
        {/foreach}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if}    
    {else}
        <div class="alert alert-danger">Закладок ещё нет...</div>
    {/if}
</div>