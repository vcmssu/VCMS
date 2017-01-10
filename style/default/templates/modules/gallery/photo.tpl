<div class="head"><a href="{$home}/gallery">Фотогалерея</a> / <a href="{$home}/gallery/{$row.id_gallery}">{$row.namealbum|escape|esc}</a> / {$title}</div>
<div class="fon">
    {if $user.level > 40}
        <div class="breadcrumb">
            <a href="{$home}/gallery/edit/{$row.id}" title="Редактировать">Редактировать</a> | 
            <a href="{$home}/gallery/del/{$row.id}" title="Удалить">Удалить</a>
        </div>
    {/if}
    <div class="breadcrumb">
        Добавил: <a href="{$home}/id{$row.id_user}">{$row.login}</a>  | Дата: {$row.time|times} | Просмотров: {$row.views|number}
    </div>
    <p><img src="{$home}/files/user/{$row.id_user}/gallery/{$row.id_gallery}/small-{$row.photo}" alt="" title="{$row.name|escape|esc}"/></p>
        {if !empty($text)}
        <p>{$text|escape|esc|nl2br}</p>
    {/if}
    <p>&nbsp;&nbsp;&nbsp;Размер: {$row.size}</p>
    <p>&nbsp;&nbsp;&nbsp;Разрешение: {$Img.0} x {$Img.1} пикс.</p>
    <div class="menu"><a href="{$home}/gallery/load/{$row.id}">Скачать оригинал</a></div>
    {if $back.id || $next.id}
        <div class="menu">
            {if $back.id}<a href="{$home}/gallery/{$back.id_gallery}/{$back.id}"><i class="fa fa-arrow-left"></i> Предыдущее фото</a>{/if}
            {if $next.id}<a{if $back.id} class="pull-right"{/if} href="{$home}/gallery/{$next.id_gallery}/{$next.id}">Следующее фото <i class="fa fa-arrow-right"></i></a>{/if}
        </div>
    {/if}
</div>