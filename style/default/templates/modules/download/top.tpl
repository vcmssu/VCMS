<div class="head"><a href="{$home}/download">Загрузки</a> / {$title}</div>
<div class="fon">
    <div class="breadcrumb">
        <a href="{$home}/download/new">Новые файлы</a> | Популярные | <a href="{$home}/download/search">Поиск файлов</a>
        {if $user.level > 40}
            | <a href="{$home}/download/moderation">На модерации ({$moderation|number})</a>
        {/if}
    </div>
    {include file='system/download.tpl'}{*вывод списка файлов*}
</div>