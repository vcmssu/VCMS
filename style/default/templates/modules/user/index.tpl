{capture name=level}
    {if $row.level == 10}
        [младший модератор]
    {else if $row.level == 20}
        [модератор]
    {else if $row.level == 30}
        [старший модератор]
    {else if $row.level == 40}
        [супер модератор]
    {else if $row.level == 50}
        [заместитель администратора]
    {else if $row.level == 100}
        [Админ]
    {/if}
{/capture}

<div class="head">
    {$title} {$smarty.capture.level}
{if $row.ban == 1}
    [Забанен до: {$row.bantime|date_format:"d.m.o, H:i"}
   {if $row.ban == 1}{$row.banprichina|escape|esc}{/if}]
{/if}
</div>
<div class="fon">
    {if $row.avatar}<div class="foto"><img src="{$home}/files/user/{$row.id}/{$row.avatar}" class="img-responsive"></div>{/if} 
    <div class="pod">
        <div class="head">Личные данные</div>
        <div class="menu">Логин: {$row.login|esc}</div>
        {if $row.firstname}<div class="menu">Имя: {$row.firstname|escape|esc}</div>{/if}
        {if $row.lastname}<div class="menu">Фамилия: {$row.lastname|escape|esc}</div>{/if}
        {if $row.city}<div class="menu">Город: {$row.city|escape|esc}</div>{/if}
        {if $row.about}<div class="menu">О себе: {$row.about|escape|esc}</div>{/if}
        <div class="menu">Дата регистрации: {$row.date_reg|times}</div>
        <div class="menu">Последнее посещение: {$row.date_last|times}</div>
    </div>
    <div class="pod">
        <div class="head">Активность на сайте</div>
        <div class="menu"><a href="{$home}/active/guest/{$row.id}">Сообщений в гостевой: {$row.guest|number}</a></div>
        <div class="menu"><a href="{$home}/active/thems/{$row.id}">Тем на форуме: {$row.counttema|number}</a></div>
        <div class="menu"><a href="{$home}/active/posts/{$row.id}">Сообщений на форуме: {$row.countpost|number}</a></div>
        <div class="menu"><a href="{$home}/active/download/{$row.id}">Файлов в загрузках: {$row.download|number}</a></div>
        <div class="menu"><a href="{$home}/active/blogs/{$row.id}">Постов в блоге: {$row.blog|number}</a></div>
        <div class="menu"><a href="{$home}/active/news/comments/{$row.id}">Комментариев к новостям: {$row.news_comments|number}</a></div>
        <div class="menu"><a href="{$home}/active/download/comments/{$row.id}">Комментариев к файлам: {$row.files_comments|number}</a></div>
        <div class="menu"><a href="{$home}/active/blogs/comments/{$row.id}">Комментариев к блогам: {$row.blog_comments|number}</a></div>
        <div class="menu"><a href="{$home}/active/gallery/{$row.id}">Фотографий в галерее: {$row.gallery_photo|number}</a></div>
        <div class="menu"><a href="{$home}/active/library/{$row.id}">Статей в библиотеке: {$row.library|number}</a></div>
        <div class="menu"><a href="{$home}/active/library/comments/{$row.id}">Комментариев к статьям: {$row.library_comments|number}</a></div>
    </div>
    {if $user.id && $row.id != $user.id}
        <div class="menu"><a href="{$home}/profile/mail/{$row.id}"><i class="fa fa-envelope"></i> Написать сообщение</a></div>
        {if $friends == 0}
            <div class="menu"><a href="{$home}/profile/friends/add/{$row.id}"><i class="fa fa-plus"></i> Добавить в друзья</a></div>    
        {else}
            <div class="menu"><a href="{$home}/profile/friends/del/{$row.id}"><i class="fa fa-minus"></i> Удалить из друзей</a></div>        
        {/if}
        {if $blacklist == 0}
            <div class="menu"><a href="{$home}/profile/blacklist/add/{$row.id}"><i class="fa fa-plus"></i> Добавить в черный список</a></div>    
        {else}
            <div class="menu"><a href="{$home}/profile/blacklist/del/{$row.id}"><i class="fa fa-minus"></i> Удалить из черного списка</a></div>        
        {/if}
    {/if}
</div>