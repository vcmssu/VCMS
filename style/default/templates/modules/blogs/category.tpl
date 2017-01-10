{if $category.id}
    <div class="head"><a href="{$home}/blogs">Блоги</a> / {$title}</div>
    <div class="fon">
        <div class="breadcrumb">
            <a href="{$home}/blogs/top">Топ постов</a> | <a href="{$home}/blogs/category">Категории</a> | <a href="{$home}/blogs/search">Поиск</a>
            {if $user.level == 100}
                <a class="pull-right" href="{$home}/blogs/category/add">Создать категорию</a>
            {/if}
        </div>
        {if $user.id}
            <div class="breadcrumb">
                <a href="{$home}/profile/blog/add">Добавить пост</a>
            </div>  
        {/if}
{include file='system/blogs.tpl'}
    </div>
{else}
    <div class="head"><a href="{$home}/blogs">Блоги</a> / {$title}</div>
    <div class="fon">
        <div class="breadcrumb">
            <a href="{$home}/blogs/top">Топ постов</a> | Категории | <a href="{$home}/blogs/search">Поиск</a>
            {if $user.level == 100}
                <a class="pull-right" href="{$home}/blogs/category/add">Создать категорию</a>
            {/if}
        </div>
        {if $user.id}
            <div class="breadcrumb">
                <a href="{$home}/profile/blog/add">Добавить пост</a>
            </div>  
        {/if}
        {if $count > 0}
            {foreach from=$arrayrow item=row}
                {counter name=num assign=num}
                <div class="menu">
                    <a href="{$home}/blogs/{$row.id}"><i class="fa fa-book"></i> {$row.name|esc}<span class="pull-right"> {$row.count|number}</span></a>
                </div>
                {if $user.level == 100}
                    <div class="breadcrumb">
                        <a href="{$home}/blogs/category/edit/{$row.id}">Параметры</a> / 
                        <a href="{$home}/blogs/category/del/{$row.id}">Удалить</a>
                        {if $num > 1}/ <a href="{$home}/blogs/category/up/{$row.id}"  title="Переместить вверх"><i class="fa fa-arrow-up"></i></a>{/if}
                        {if $num != $count}/ <a href="{$home}/blogs/category/down/{$row.id}" title="Переместить вниз"><i class="fa fa-arrow-down"></i></a>{/if}
                    </div>
                {/if}
            {/foreach}
        {else}
            <div class="alert alert-danger">Категорий ещё нет...</div>
        {/if}
    </div>
{/if}