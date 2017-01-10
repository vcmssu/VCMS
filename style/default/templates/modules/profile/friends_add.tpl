<div class="head"><a href="{$home}/profile">Мой кабинет</a> / <a href="{$home}/profile/friends">Друзья</a> / {$title}</div>
<div class="fon">
    {if $blacklist == 0}
        <div class="alert alert-success">Заявка на добавление в друзья успешно отправлена!</div>
    {else}
        <div class="alert alert-danger">Вы не можете добавить пользователя в друзья так как находитесь у него в черном списке!</div>    
    {/if}
</div>