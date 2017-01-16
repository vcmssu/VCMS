{capture name=level}
    {if $rows.level == 10}
        [младший модератор]
    {else if $rows.level == 20}
        [модератор]
    {else if $rows.level == 30}
        [старший модератор]
    {else if $rows.level == 40}
        [супер модератор]
    {else if $rows.level == 50}
        [заместитель администратора]
    {else if $rows.level == 100}
        [Админ]
    {/if}
{/capture}

{capture name=comments}
    <div class="post-user">
        <div class="img"><img src="{$home}/files/{if $rows.avatar}user/{$rows.id_user}/small-{$rows.avatar}{else}nophoto.jpg{/if}"/></div>
        <p>
            {if $rows.id_user}
            {if $rows.login}<a href="{$home}/id{$rows.id_user}">{$rows.login|esc}</a> {$smarty.capture.level}{else}<i class="fa fa-trash"></i> Пользователь удалён{/if}{elseif $rows.name}
            {$rows.name|esc}{else}Гость{/if} ({$rows.time|times})
            {if $user.level > 1}
                {if $rows.ip}<br/>IP: {$rows.ip}{/if}
                {if $rows.browser}Браузер: {$rows.browser}{/if}
                {if $rows.referer}Где: <a href="{$rows.referer}">{$rows.referer}</a>{/if}
            {/if}
        </p>
    </div>
{/capture}

{capture name=forum}
    <div class="post-user">
        <div class="img"><img src="{$home}/files/{if $rows.avatar}user/{$rows.id_user}/small-{$rows.avatar}{else}nophoto.jpg{/if}"/></div>
            <span class="pull-right margin-top-10">
                <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id_tema}/post/{$rows.id}" title="Просмотреть пост"><i class="fa fa-info"></i></a>
                {if $user.id && $rows.id_user != $user.id}
                <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id_tema}/reply/{$rows.id}" title="Ответить"><i class="fa fa-reply"></i></a>
                <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id_tema}/quote/{$rows.id}" title="Цитировать"><i class="fa fa-quote-left"></i></a>
                {/if}
            </span>
        <p>{if $rows.login}<a href="{$home}/id{$rows.id_user}">{$rows.login|esc}</a> {$smarty.capture.level}{else}<i class="fa fa-trash"></i> Пользователь удалён{/if} ({$rows.time|times})</p>
    </div>
{/capture}

{capture name=voteforum}
    <div class="post-user">
        <div class="img"><img src="{$home}/files/{if $rows.avatar}user/{$rows.id_user}/small-{$rows.avatar}{else}nophoto.jpg{/if}"/></div>
        <p>
            {if $rows.login}<a href="{$home}/id{$rows.id_user}">{$rows.login|esc}</a> {$smarty.capture.level}{else}<i class="fa fa-trash"></i> Пользователь удалён{/if} ({$rows.time|times})
            <br/>Проголосовал за: <b>{$rows.option|esc|escape}</b>
        </p>
    </div>
{/capture}

{capture name=users}
    <div class="post-user">
        <div class="img"><img src="{$home}/files/{if $rows.avatar}user/{$rows.id}/small-{$rows.avatar}{else}nophoto.jpg{/if}"/></div>
        <p>
            <a href="{$home}/id{$rows.id}">{$rows.login|esc}</a> {$smarty.capture.level}
            <br/> Последнее посещение: {$rows.date_last|times}
        </p>
    </div>
{/capture}

{capture name=text}
    <p>{$text.$k|escape|esc|nl2br}</p>
{/capture}