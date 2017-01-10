<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}">{$tema.name|escape|esc}</a> / Файлы</div>
<div class="fon">
    {if $count > 0}
        <div class="list text">
            {foreach from=$arrayrowfile item=file}
                <p class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/load/{$file.id}" title="Скачать файл"><i class="fa fa-file"></i> {$file.file|escape|esc}</a> ({$file.size|escape|esc}{if $file.loadcounts > 0}, скачиваний: {$file.loadcounts|number}{/if})</p>   
            {/foreach}
        </div>
    {else}
        <div class="alert alert-danger">Файлов в теме ещё нет...</div>
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if}     
</div>