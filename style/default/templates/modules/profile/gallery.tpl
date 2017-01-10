{if $row.id}
    <div class="head"><a href="{$home}/profile">Мой кабинет</a> / <a href="{$home}/profile/gallery">{$title}</a> / {$row.name|escape|esc}</div>
    <div class="fon">
        <div class="breadcrumb"><a href="{$home}/profile/gallery/{$row.id}/add">Добавить фото</a></div>
        {if $count > 0}
            {foreach from=$arrayrow item=rows}
                <div class="list">
                    <img src="{$home}/files/user/{$rows.id_user}/gallery/{$rows.id_gallery}/small-{$rows.photo}" alt="" title="{$rows.name|escape|esc}"/>
                    <h4><a href="{$home}/gallery/{$rows.id_gallery}/{$rows.id}">{$rows.name|escape|esc}</a></h4>
                    <p>
                        <strong>Добавлена:</strong> {$rows.time|times}<br/>
                        <strong>Вес файла:</strong> {$rows.size}<br>
                        <strong>Просмотров:</strong> {$rows.views|number}
                    </p>
                    <span class="breadcrumb">
                        <a href="{$home}/profile/gallery/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                        <a href="{$home}/profile/gallery/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                    </span>
                </div>
            {/foreach}
        {else}
            <div class="alert alert-danger">Фотографий ещё нет...</div>
        {/if}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if} 
    </div>    
{else}
    <div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}<span class="pull-right"><a href="{$home}/profile/gallery/add">Создать альбом</a></span></div>
    <div class="fon">
        {if $count > 0}
            {foreach from=$arrayrow item=rows}
                <div class="list">
                    <a href="{$home}/profile/gallery/{$rows.id}" class="title" title="Просмотреть">{$rows.name|escape|esc} ({$rows.count|number})</a>
                    <span class="breadcrumb">
                        <a href="{$home}/profile/gallery/edit/album/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                        <a href="{$home}/profile/gallery/del/album/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                    </span>
                </div>
            {/foreach}
        {else}
            <div class="alert alert-danger">Альбомов ещё нет...</div>
        {/if}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if} 
    </div>
{/if}