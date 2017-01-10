<div class="head"><a href="{$home}/gallery">Фотогалерея</a>  / {$title}</div>
<div class="fon">
    <div class="breadcrumb">
        <a href="{$home}/gallery/top">Топ фотографий</a> | Альбомы
    </div>
    {if $count > 0}
        {foreach from=$arrayrow item=row}
            <div class="menu">
                <a href="{$home}/gallery/{$row.id}"><i class="fa fa-photo"></i> {$row.name|esc}<span class="pull-right"> {$row.count|number}</span></a>
            </div>
            {if $user.level > 40}
                <div class="breadcrumb">
                    <a href="{$home}/gallery/album/edit/{$row.id}">Параметры</a> / 
                    <a href="{$home}/gallery/album/del/{$row.id}">Удалить</a>
                </div>
            {/if}
        {/foreach}
    {else}
        <div class="alert alert-danger">Альбомов ещё нет...</div>
    {/if}
</div>