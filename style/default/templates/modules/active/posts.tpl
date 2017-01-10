<div class="head"><a href="{$home}/id{$row.id}">{$row.login|escape|esc}</a> / {$title}</div>
<div class="fon">
    {include file='system/posts.tpl'}
    {if empty($user.id)}
        <div class="fon">
            <div class="alert alert-danger margin-top-10">Гостям не отображаются закрытые от не авторизованных посты!</div>
        </div>    
    {else if $user.level < 10}
        <div class="fon">
            <div class="alert alert-danger margin-top-10">Скрытые посты отображаются только администрации сайта!</div>
        </div> 
    {/if} 
</div>