<div class="head">{$title}</div>
<div class="fon">
    <div class="alert alert-info">Бан истекает: {$user.bantime|times}</div>
    {if $user.banprichina}
        <div class="alert alert-danger">{$banprichina|escape|esc}</div>
    {/if}
</div>