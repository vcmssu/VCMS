<div class="head">{$title}</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=rows}
            <div class="list">
                {include file='system/user.tpl'}
                {$smarty.capture.comments}
            </div>
        {/foreach}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if}    
    {else}
        <div class="alert alert-danger">Гостей на сайте нет...</div>
    {/if}
</div>