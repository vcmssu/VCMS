<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|escape|esc}</a> / {$title|escape}</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=rows}
            <div class="list text">
                {include file='system/user.tpl'}
                {$smarty.capture.voteforum}
            </div>
        {/foreach}
    {else}
        <div class="alert alert-danger">Ещё никто не голосовал...</div>
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if} 
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|escape|esc}</a></div> 