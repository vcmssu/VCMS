<div class="head"><a href="{$home}/id{$row.id}">{$row.login|escape|esc}</a> / {$title}</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=rows key=k}
            <div class="list text">
                {include file='system/user.tpl'}
                {$smarty.capture.comments}
                {$smarty.capture.text}
                {if $user.level > 9}
                    <span class="head">
                        <a href="{$home}/guest/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a> 
                            {if $user.level > 10}
                            <a href="{$home}/guest/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                            {/if}
                    </span>
                {/if}
            </div><hr/>
        {/foreach}
    {else}
        <div class="alert alert-danger">Сообщений ещё нет...</div>
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if} 
</div>