<div class="head"><a href="{$home}/download">Загрузки</a> / {$title}</div>
<div class="fon">
<div class="breadcrumb"><a href="{$home}/download/new">Новые файлы</a> | <a href="{$home}/download/top">Популярные</a> | Поиск файлов</div>
    <form action="{$home}/download/search" method="post" class="fon">
        <p><input type="text" name="search" value="{$search|escape|esc}" class="form-control"/></p>
        <p><input type="submit" name="ok" value="Найти" class="btn btn-primary"></p>
    </form>
    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}
    {if $count_files > 0 && !isset($error) && $search}
        <div class="alert alert-info">Результаты поиска по запросу: <b>{$search|escape|esc}</b></div>
        {foreach from=$arrayrow_files item=row_files}
            <div class="list" id="{$row_files.id}">
                {if $row_files.type == 'jpg' || $row_files.type == 'jpeg' || $row_files.type == 'png' || $row_files.type == 'gif'}
                    <img src="{$home}/{$row_files.path}small_{$row_files.file}" alt="" />
                {/if}
                {if $row_files.screen}
                    <img src="{$home}/{$row_files.path}small_{$row_files.screen}" alt="" />
                {else}
                    {if $row_files.type == 'nth' || $row_files.type == 'thm'}
                        <img src="{$home}/{$row_files.path}{$row_files.file}.GIF" alt="" />
                    {/if}	               
                    {if $setup.autoscreen_video == 1}
                        {if $row_files.type == 'mp4' || $row_files.type == 'avi' || $row_files.type == '3gp' || $row_files.type == 'wmv'}
                            <img src="{$home}/{$row_files.path}small_{$row_files.file}.GIF" alt="" />
                    {/if}{/if}
                {/if}
                <h4>
                    {*иконка к jar файлу*}  
                    {if $row_files.type == 'jar'}<img src="{$home}{$row_files.path}{$row_files.file}.icon.png" alt="" />
                    {else}
                        {*иконка к остальным файлам*}
                    {capture assign='icon'}{$home}/files/icons/{$row_files.type}.png{/capture}                   
                    {if $icon|file_exists eq ''}
                        <img src="{$home}/files/icons/{$row_files.type}.png" alt="" />
                    {else}
                        <img src="{$home}/files/icons/stand.png" alt="" />
                    {/if}
                {/if}
                <a href="{$home}/download/{$row_files.id}-{$row_files.translate}">{$row_files.name|escape|esc}</a>
            </h4>
            <p>
                <strong>Добавлен:</strong> {$row_files.time|times}<br/>
            {if !empty({$row_files.timeload})}<strong>Последний раз скачан:</strong> {$row_files.timeload|times}<br/>{/if}
            <strong>Вес файла:</strong> {$row_files.size}<br>
            <strong>Просмотров:</strong> {$row_files.views|number}<br/>
            <strong>Скачиваний:</strong> {$row_files.loadcounts|number}
        </p>
        {if $user.level > 40}
            <span class="breadcrumb">
                    <a href="{$home}/download/edit/{$row_files.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                    <a href="{$home}/download/del/{$row_files.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                    <a href="{$home}/download/file/{$row_files.id}" title="Дополнительные файлы"><i class="fa fa-upload"></i></a>
            </span>
        {/if}
    </div>
{/foreach}
{*постраничка*} 
{if $count_files > $message}
    <div class="paging_bootstrap pagination">{$pagenav}</div>
{/if}
{/if}
{if $count_files == 0 && !isset($error) && $search}
    <div class="alert alert-danger">По вашему запросу ничего не найдено!</div>
{/if}
</div>