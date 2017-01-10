<div class="head"><a href="{$home}/blogs">Блоги</a> / {$title}
</div>
<div class="fon">
    <div class="breadcrumb">
        <a href="{$home}/blogs/top">Топ постов</a> | <a href="{$home}/blogs/category">Категории</a> | Поиск
        {if $user.level == 100}
            <a class="pull-right" href="{$home}/blogs/category/add">Создать категорию</a>
        {/if}
    </div>
    {if $user.id}
        <div class="breadcrumb">
            <a href="{$home}/profile/blog/add">Добавить пост</a>
        </div>  
    {/if}
    <form action="{$home}/blogs/search" method="post" class="fon">
        <p><input type="text" name="search" value="{$search|escape|esc}" class="form-control"/></p>
        <p><input type="submit" name="ok" value="Найти" class="btn btn-primary"></p>
    </form>
    {if isset($error)}
        <div class="alert alert-danger margin-top-10">{$error}</div>
    {/if}
    {if $count > 0 && !isset($error) && $search}
        {foreach from=$arrayrow item=rows}
            <div class="list">
                <a href="{$home}/blogs/{$rows.refid}/{$rows.id}-{$rows.translate}" class="title" title="Просмотреть">{$rows.name|esc|escape}</a> ({$rows.time|times})
                <p class="line">Автор: <a href="{$home}/id{$rows.id_user}">{$rows.login|esc|escape}</a></p>
                <p class="line">Категория: <a href="{$home}/blogs/{$rows.refid}">{$rows.namecat|esc|escape}</a></p>
                <p class="line"><a href="{$home}/blogs/comments/{$rows.id}">Комментарии ({$rows.count|number})</a></p>
                {if $user.level > 30}
                    <span class="breadcrumb">
                        <a href="{$home}/blogs/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                        <a href="{$home}/blogs/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                    </span>
                {/if}
            </div>
        {/foreach}
    {/if}
    {*постраничка*} 
    {if $count > $message}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if}
    {if $count == 0 && !isset($error) && $search}
        <div class="alert alert-danger">По вашему запросу ничего не найдено!</div>
    {/if}
</div>