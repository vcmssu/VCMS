<div class="head"><a href="{$home}/blogs">Блоги</a> / {$title}</div>
<div class="fon">
    <div class="breadcrumb">
        Топ постов | <a href="{$home}/blogs/category">Категории</a> | <a href="{$home}/blogs/search">Поиск</a>
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