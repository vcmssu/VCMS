<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=row}
            <div class="list" id="{$row.id}">
                <a href="{$home}/id{$row.user_id}">{$row.login|escape|esc}</a> ({$row.time|times})
                <span class="pull-right">
                    <a href="{$home}/profile/blacklist/del/{$row.user_id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                </span>
            </div>
        {/foreach}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if}    
    {else}
        <div class="alert alert-danger">Черный список пуст...</div>
    {/if}
</div>