<div class="head">{$title}</div>
{nocache}
<div class="fon">
    {if $user.id || $setup.guest == 1}
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
        <form action="{$url}" method="post" class="fon">
            {if empty($user.id)}
                <p>Имя: <br/><input type="text" name="name" class="form-control" value="{$smarty.cookies.name|esc}"/></p>
                {include file='system/captcha.tpl'}
            {/if}
            <p>Текст сообщения: <br/>
                {include file='system/panel.tpl'} 
                {$smarty.capture.add_comments}
            </p>
            <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
        </form>
    {else}
        <div class="alert alert-danger margin-top-10">Для того, чтобы оставлять сообщения, Вам нужно <a href="{$home}/user/login">авторизоваться</a> или <a href="{$home}/user/signup">зарегистрироваться</a> на сайте!</div>    
    {/if}
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
    {/nocache}
</div>