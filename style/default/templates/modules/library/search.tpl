<div class="head"><a href="{$home}/library">Библиотека</a> / {$title}</div>
<div class="fon">
    <div class="breadcrumb">
        <a href="{$home}/library/top">Топ статей</a> | Поиск
    </div>
    <form action="{$home}/library/search" method="post" class="fon">
        <p><input type="text" name="search" value="{$search|escape|esc}" class="form-control"/></p>
        <p><input type="submit" name="ok" value="Найти" class="btn btn-primary"></p>
    </form>
    {if isset($error)}
        <div class="alert alert-danger margin-top-10">{$error}</div>
    {/if}
    {if $countart > 0 && !isset($error) && $search}
        <div class="margin-top-10 alert alert-info">Результаты поиска по запросу: <b>{$search|escape|esc}</b></div>
        {foreach from=$arrayrowart item=rows key=k}
            <div class="list">
                <a href="{$home}/library/{$rows.id}-{$rows.translate}" class="title" title="Просмотреть">{$rows.name|escape|esc}</a> ({$rows.time|times})
                <p class="line">Добавил: <a href="{$home}/id{$rows.id_user}">{$rows.login|escape|esc}</a></p>
                <p class="line">{$text.$k|esc|strip_tags:false|truncate:220|nl2br}</p>
                <p class="line">Рейтинг: {if $rows.rating == 0}
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    {else if $rows.rating > 0 && $rows.rating < 2}
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        {else if $rows.rating > 1 && $rows.rating < 3}
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            {else if $rows.rating > 2 && $rows.rating < 4}
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                {else if $rows.rating > 3 && $rows.rating < 5}
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    {else if $rows.rating > 4}
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        {/if}</p>
                                        <p class="line"><a href="{$home}/library/comments/{$rows.id}">Комментарии ({$rows.comments|number})</a></p>
                                        {if $user.level > 30}
                                            <span class="breadcrumb">
                                                <a href="{$home}/library/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                                                <a href="{$home}/library/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                                            </span>
                                        {/if}
                                    </div>
                                    {/foreach}
                                        {/if}
                                            {*постраничка*} 
                                            {if $countart > $message}
                                                <div class="paging_bootstrap pagination">{$pagenav}</div>
                                            {/if}
                                            {if $countart == 0 && !isset($error) && $search}
                                                <div class="alert alert-danger">По вашему запросу ничего не найдено!</div>
                                            {/if}
                                        </div>