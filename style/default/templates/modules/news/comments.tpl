<div class="head">
    <a href="{$home}/news">Новости</a> / <a href="{$home}/news/{$row.id}-{$row.translate}">{$row.name|esc}</a> / 
    {$title}
</div>
<div class="fon">
    {if $user.level > 29}
        <div class="breadcrumb">
            <a href="{$home}/news/edit/{$row.id}">Редактировать</a> / 
            {if $user.level > 30}
                <a href="{$home}/news/del/{$row.id}">Удалить</a> / 
            {/if}
            {if $user.level > 40}
                <a href="{$home}/news/mail/{$row.id}">Произвести рассылку</a> / 
            {/if}
            <a href="{$home}/news/all">Все новости</a> / 
            <a href="{$home}/news/add">Добавить новость</a>
        </div>
    {/if}
    {if $user.id}
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
        {if $row.comments == 1}
            <form action="{$url}" method="post" class="fon">
                <p>Текст сообщения: <br/>
                    {include file='system/panel.tpl'}
                    {$smarty.capture.add_comments}
                </p>
                {if $setup.captcha_comments_news == 1}
                    {include file='system/captcha.tpl'}
                {/if}
                <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
            </form>
        {/if}
    {else}
        {include file='system/error.tpl'}
        {$smarty.capture.comments}  
    {/if}
    {if $row.comments == 1}
        {if $count > 0}
            {foreach from=$arrayrow item=rows key=k}
                <div class="list text">
                    {include file='system/user.tpl'}
                    {$smarty.capture.comments}
                    {$smarty.capture.text}
                    {if $user.level > 9}
                        <span class="breadcrumb">
                            <a href="{$home}/news/edit/comments/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a> 
                                {if $user.level > 10}
                                <a href="{$home}/news/del/comments/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                                {/if}
                        </span>
                    {/if}
                </div>
            {/foreach}
        {else}
            <div class="alert alert-danger">Комментариев к новости ещё нет...</div>
        {/if}
    {else}
        <div class="alert alert-danger">Комментарии к этой новости отключены!</div>
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if} 
</div>