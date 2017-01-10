<div class="head">{$title}
    {if $user.level == 100}
        <span class="pull-right">
            <a href="{$home}/news/all">Все новости</a> / 
            <a href="{$home}/news/add">Добавить новость</a>
        </span>
    {/if}
</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=rows key=k}
            <div class="list">
                <a href="{$home}/news/{$rows.id}-{$rows.translate}" class="title">{$rows.name|esc}</a> ({$rows.time|times})
                <p>{$text.$k|esc|strip_tags:false|truncate:220|nl2br}</p>
                {if $rows.comments == 1}<p class="line"><a href="{$home}/news/comments/{$rows.id}">Комментарии ({$rows.count|number})</a></p>{/if}
                {if $user.level > 29}
                    <span class="breadcrumb">
                        <a href="{$home}/news/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                            {if $user.level > 30}
                            <a href="{$home}/news/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                            {/if}
                    </span>
                {/if}
            </div>
        {/foreach}
    {else}
        <div class="alert alert-danger">Новостей ещё нет...</div>
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if} 
</div>