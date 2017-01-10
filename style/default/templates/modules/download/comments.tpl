<div class="head"><a href="{$home}/download">Загрузки</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if $user.id}
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
        <form action="{$url}" method="post" class="fon">
            <p>Текст сообщения: <br/>
                {include file='system/panel.tpl'} 
                {$smarty.capture.add_comments}
            </p>
            {if $setup.captcha_comments_file == 1}
                {include file='system/captcha.tpl'}
            {/if}
            <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
        </form>
    {else}
        {include file='system/error.tpl'}
        {$smarty.capture.comments}    
    {/if}
    {if $count > 0}
        {foreach from=$arrayrow item=rows key=k}
            <div class="list" id="{$rows.id}">
                {include file='system/user.tpl'}
                {$smarty.capture.comments}
                {$smarty.capture.text}
                {if $user.level > 9}
                    <span class="breadcrumb">
                        <a href="{$home}/download/edit/comments/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a> 
                            {if $user.level > 10}
                            <a href="{$home}/download/del/comments/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                            {/if}
                    </span>
                {/if}
            </div>
        {/foreach}
    {else}
        <div class="alert alert-danger">Комментариев к файлу ещё нет...</div>
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if} 
</div>
<div class="menu"><a href="{$home}/download/{$row.id}-{$row.translate}"><i class="fa fa-angle-left"></i> К файлу {$row.name|esc}</a></div> 