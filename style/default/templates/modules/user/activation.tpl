<div class="head">{$title}</div>
<div class="fon">
    {if $error}
        <div class="alert alert-danger">{$error}</div>
    {else}
        <div class="alert alert-success">Вы успешно активировали свой аккаунт. Теперь можете авторизоваться.</div>
    {/if}
</div>