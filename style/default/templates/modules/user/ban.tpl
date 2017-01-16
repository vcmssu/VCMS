<div class="head">{$title}</div>
<div class="fon">
    <div class="alert alert-info">Бан истекает: {$user.bantime|date_format:"d.m.o, H:i"}</div>
    {if $user.banprichina}
        <div class="alert alert-danger">{$banprichina|escape|esc}</div>
    {/if}
</div>