<div class="head"><a href="{$home}/forum">Форум</a> / {$title}</div>
<div class="fon">
    <div class="breadcrumb">Новые: <a href="{$home}/forum/new/thems">темы</a> | <a href="{$home}/forum/new/posts">посты</a> | поиск</div>
    <form action="{$home}/forum/search" method="post" class="fon">
        <p><input type="text" name="search" value="{$search|esc}" class="form-control"/></p>
        <p><input type="submit" name="ok" value="Найти" class="btn btn-primary"></p>
    </form>
    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}
    {if $count > 0 && !isset($error) && $search}
        <div class="alert alert-info">Результаты поиска по запросу: <b>{$search|escape|esc}</b></div>
        {foreach from=$arrayrow item=rows key=k}
            <div class="list">
                {if $rows.closed == 1}<i class="fa fa-close"></i>{/if}
                {if $rows.up == 1}<i class="fa fa-exclamation-triangle"></i>{/if}
                <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id}">{$rows.name|escape|esc} ({$rows.countpost})</a> 
                <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id}?page={$starts.$k}#{$rows.id_post_last}" title="Последнее сообщение"><i class="fa fa-angle-double-right"></i></a>
                <a href="{$home}/id{$rows.id_user_last}">{$rows.login|escape|esc}</a><span class="pull-right">({$rows.time|times})</span>
            </div>
        {/foreach}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if} 
    {/if}   
    {if $count == 0 && !isset($error) && $search}
        <div class="alert alert-danger">По вашему запросу ничего не найдено!</div>
    {/if}
</div>