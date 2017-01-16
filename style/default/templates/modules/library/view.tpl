<div class="head"><a href="{$home}/library">Библиотека</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if $user.level > 30}
        <div class="breadcrumb">
            <a href="{$home}/library/edit/{$row.id}" title="Редактировать">Редактировать</a> | 
            <a href="{$home}/library/del/{$row.id}" title="Удалить">Удалить</a>
        </div>
    {/if}
    <div class="breadcrumb">
        Добавил: <a href="{$home}/id{$row.id_user}">{$row.login|escape|esc}</a> {if $row.autor}| Автор: <a href="{$home}/library/search/{$row.autor|escape|esc}">{$row.autor|escape|esc}</a>{/if} | Дата: {$row.time|times} | Просмотров: {$row.views|number}
    </div>
    {if $smarty.post.ok}
        <div class="alert alert-success">Спасибо, Ваш голос учтён!</div>
    {/if}
    <h1>{$title}</h1>
    {$text|escape|esc|nl2br}
    {*постраничка*} 
    {if $pages > 1}
        <div class="paging_bootstrap pagination">{$pagenav}</div>
    {/if}  
    <p class="margin-top-10 menu"><a href="{$home}/library/comments/{$row.id}">Комментарии ({$count|number})</a></p>
    <p class="menu">
        Рейтинг: 
        {if $row.rating == 0}
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
        {else if $row.rating > 0 && $row.rating < 2}
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
        {else if $row.rating > 1 && $row.rating < 3}
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
        {else if $row.rating > 2 && $row.rating < 4}
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
        {else if $row.rating > 3 && $row.rating < 5}
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
        {else if $row.rating > 4}
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
        {/if}
    </p>
    {if $user.id && $row.voteus == 0 && empty($smarty.post.ok)}
        <div><form action="{$url}" method="post">
            <select name="rating" class="form-control" style="width:75%">
                <option value="5">отлично</option>   
                <option value="4">хорошо</option>   
                <option value="3">нормально</option>  
                <option value="2">плохо</option>     
                <option value="1">ужасно</option>           
            </select>
            <input type="submit" name="ok" value="Оценить" class="btn btn-primary pull-right" style="margin-top:-50px;">
        </form></div>
    {/if}
    <div class="list">Скачать: <a href="{$home}/library/txt/{$row.id}">TXT</a></div>
</div>