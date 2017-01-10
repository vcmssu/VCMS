<div class="head"><a href="{$home}/id{$row.id}">{$row.login|escape|esc}</a> / {$title}</div>
<div class="fon">
    {include file='system/thems.tpl'}
    {if empty($user.id)}
        <div class="fon">
            <div class="alert alert-danger margin-top-10">Гостям не отображаются закрытые от не авторизованных темы!</div>
        </div>    
    {else if $user.level < 10}
        <div class="fon">
            <div class="alert alert-danger margin-top-10">Скрытые темы отображаются только администрации сайта!</div>
        </div> 
    {/if}    
</div>