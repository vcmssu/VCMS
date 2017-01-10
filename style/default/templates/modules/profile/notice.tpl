<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=row key=k}
            <div class="list" id="{$row.id}">
                <a href="{$home}/id{$row.user_id}">{$row.login|esc}</a>, {$row.time|times}
                {$text.$k|escape|esc|nl2br}
            </div>
        {/foreach}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if}    
    {else}
        <div class="alert alert-danger">Уведомлений ещё нет...</div>
    {/if}
</div>