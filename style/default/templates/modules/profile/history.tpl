<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">
{if $count > 0}
    {foreach from=$arrayrow item=row}
        <div class="list" id="{$row.id}">
            {$row.ip|esc}, {$row.browser|esc}, {$row.time|times}
        </div>
    {/foreach}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if}    
{else}
    <div class="alert alert-danger">История авторизаций пуста...</div>
{/if}
</div>