<div class="head">{$title} / <a href="{$home}/users/admin">Администрация сайта</a></div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=rows}
            <div class="list">
                {include file='system/user.tpl'}
                {$smarty.capture.users}
            </div>
        {/foreach}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if}    
    {else}
        <div class="alert alert-danger">Пользователей ещё нет...</div>
    {/if}
</div>