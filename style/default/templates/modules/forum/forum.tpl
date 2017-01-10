<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / {$row.name|escape|esc}
    {if $user.id}
        <span class="pull-right">
            <a href="{$home}/forum/{$forum.id}/{$row.id}/add">Создать тему</a>
        </span>
    {/if}
</div>
<div class="fon">
    {if $user.level == 100}
        <div class="breadcrumb right">
            <a href="{$home}/forum/setup/{$row.id}">Параметры</a> / 
            <a href="{$home}/forum/setup/del/{$row.id}">Удалить</a>
        </div>
    {/if}
    {if $count > 0}
        {foreach from=$arrayrow item=rows key=k}
            <div class="list">
                {if $rows.closed == 1}<i class="fa fa-close"></i>{/if}
                {if $rows.up == 1}<i class="fa fa-exclamation-triangle"></i>{/if}
                <a href="{$home}/forum/{$forum.id}/{$row.id}/{$rows.id}">{$rows.name|escape|esc} ({$rows.countpost})</a> 
                <a href="{$home}/forum/{$forum.id}/{$row.id}/{$rows.id}?page={$starts.$k}#{$rows.id_post_last}" title="Последнее сообщение"><i class="fa fa-angle-double-right"></i></a>
                <a href="{$home}/id{$rows.id_user_last}">{$rows.login|escape|esc}</a>
                <span class="pull-right hidden-xs hidden-sm">{$rows.time|times}</span>
                <span class="menu visible-xs">{$rows.time|times}</span>
            </div>
        {/foreach}
    {else}
        <div class="alert alert-danger">Тем в этом разделе нет...</div>
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if} 
</div>