<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">
    {if $countart > 0}
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
                                        <span class="breadcrumb">
                                            <a href="{$home}/profile/library/edit/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                                            <a href="{$home}/profile/library/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                                        </span>
                                    </div>
                                    {/foreach}
                                        {else}
                                            <div class="alert alert-danger">Статей ещё нет...</div>
                                            {/if}
                                                {*постраничка*} 
                                                {if $countart > $message}
                                                    <div class="paging_bootstrap pagination">{$pagenav}</div>
                                                {/if}
                                            </div>