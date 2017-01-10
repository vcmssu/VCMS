{if $count > 0}
    {foreach from=$arrayrow item=rows key=k}
        <div class="list" id="{$rows.id}">
            {include file='system/user.tpl'}
            {$smarty.capture.forum}
            {$smarty.capture.text}
            {if $arrayrowfile && $rows.count_file > 0}
                <h4>Прикрепленные файлы:</h4>
                {foreach from=$arrayrowfile item=file}
                    {if $rows.id == $file.id_post}
                        <p class="menu"><a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id_tema}/load/{$file.id}" title="Скачать файл"><i class="fa fa-file"></i> {$file.file|esc}</a> ({$file.size|esc}{if $file.loadcounts > 0}, скачиваний: {$file.loadcounts|number}{/if})</p>   
                    {/if}
                {/foreach}
            {/if}
            <div class="menu"><a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id_tema}"><i class="fa fa-angle-right"></i> В тему {$rows.nametema|escape|esc}</a></div>
        </div>
    {/foreach}
{else}
    <div class="alert alert-danger">Постов ещё нет...</div>
{/if}
{*постраничка*} 
{if $count > $message}
    <div class="paging_bootstrap pagination">{$pagenav}</div>
{/if}