{if $row.id}
    <div class="head"><a href="{$home}/gallery">Фотогалерея</a> / {$title}</div>
    <div class="fon">
        <div class="breadcrumb">
            <a href="{$home}/gallery/top">Топ фотографий</a> | <a href="{$home}/gallery/albums">Альбомы</a>
        </div>
        {if $count > 0}
            {foreach from=$arrayrow item=rows}
                <div class="list">
                    <img src="{$home}/files/user/{$rows.id_user}/gallery/{$rows.id_gallery}/small-{$rows.photo}" alt="" title="{$rows.name|escape|esc}"/>
                    <h4><a href="{$home}/gallery/{$rows.id_gallery}/{$rows.id}">{$rows.name|escape|esc}</a></h4>
                    <p>
                        <strong>Альбом:</strong> <a href="{$home}/gallery/{$rows.id_gallery}">{$rows.namealbum|escape|esc}</a><br/>
                        <strong>Добавлена:</strong> {$rows.time|times}<br/>
                        <strong>Вес файла:</strong> {$rows.size}<br>
                        <strong>Просмотров:</strong> {$rows.views|number}
                    </p>
                    {if $user.level > 40}
                        <span class="breadcrumb">
                            <a href="{$home}/gallery/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                            <a href="{$home}/gallery/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                        </span>
                    {/if}
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
    <div class="head">{$title}</div>
    <div class="fon">
        <div class="breadcrumb">
            <a href="{$home}/gallery/top">Топ фотографий</a> | <a href="{$home}/gallery/albums">Альбомы</a>
        </div>
        {if $count > 0}
            {foreach from=$arrayrow item=rows}
                <div class="list">
                    <img src="{$home}/files/user/{$rows.id_user}/gallery/{$rows.id_gallery}/small-{$rows.photo}" alt="" title="{$rows.name|escape|esc}"/>
                    <h4><a href="{$home}/gallery/{$rows.id_gallery}/{$rows.id}">{$rows.name|escape|esc}</a></h4>
                    <p>
                        <strong>Альбом:</strong> <a href="{$home}/gallery/{$rows.id_gallery}">{$rows.namealbum|escape|esc}</a><br/>
                        <strong>Добавлена:</strong> {$rows.time|times}<br/>
                        <strong>Вес файла:</strong> {$rows.size}<br>
                        <strong>Просмотров:</strong> {$rows.views|number}
                    </p>
                    {if $user.level > 40}
                        <span class="breadcrumb">
                            <a href="{$home}/gallery/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                            <a href="{$home}/gallery/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                        </span>
                    {/if}
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
{/if}