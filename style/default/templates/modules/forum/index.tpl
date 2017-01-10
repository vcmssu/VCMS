{if $rows.id}
    <div class="head"><a href="{$home}/forum">Форум</a> / {$title}
        {if $user.level == 100}
            <span class="pull-right">
                <a href="{$home}/forum/setup/add/{$rows.id}">Создать раздел</a>
            </span>
        {/if}
    </div>
    <div class="fon">    
        <div class="breadcrumb">Новые: <a href="{$home}/forum/new/thems">темы</a> | <a href="{$home}/forum/new/posts">посты</a> | <a href="{$home}/forum/search">поиск</a></div>
        {if $count > 0}
            {foreach from=$arrayrow item=row key=k}
                {counter name=num assign=num}
                <div class="menu">  
                    <a href="{$home}/forum/{$row.refid}/{$row.id}"><i class="fa fa-book"></i>
                        {$row.name|esc}<span class="pull-right"> {$row.counttema|number} / {$row.countpost|number}</span></a>
                    {if $row.text}<div class="post-user">{$text.$k|escape|esc|nl2br}</div>{/if}
                </div>
                {if $user.level == 100}
                    <div class="breadcrumb">
                        <a href="{$home}/forum/setup/{$row.id}">Параметры</a> / 
                        <a href="{$home}/forum/setup/del/{$row.id}">Удалить</a> {if $count > 1} / {/if} 
                        {if $num > 1}<a href="{$home}/forum/setup/up/{$row.refid}/{$row.id}"  title="Переместить вверх"><i class="fa fa-arrow-up"></i></a>{/if}
                        {if $num != $count}<a href="{$home}/forum/setup/down/{$row.refid}/{$row.id}" title="Переместить вниз"><i class="fa fa-arrow-down"></i></a>{/if}
                    </div>
                {/if}
                <div class="margin-top-10"></div>
            {/foreach}
        {else}
            <div class="alert alert-danger">Разделы ещё не созданы...</div>
        {/if}
    </div>    
{else}
    <div class="head">{$title}
        {if $user.level == 100}
            <span class="pull-right">
                <a href="{$home}/forum/setup/add">Создать раздел</a>
            </span>
        {/if}
    </div>
    <div class="fon">
        <div class="breadcrumb">Новые: <a href="{$home}/forum/new/thems">темы</a> | <a href="{$home}/forum/new/posts">посты</a> | <a href="{$home}/forum/search">поиск</a></div>
        {if $count > 0}
            {foreach from=$arrayrow item=row key=k}
                {counter name=num assign=num}
                <div class="pod">
                    <div class="head">  
                        <a href="{$home}/forum/{$row.id}"><i class="fa fa-book"></i>
                            {$row.name|esc}<span class="pull-right"> {$row.counttema|number} / {$row.countpost|number}</span></a>
                        {if $row.text}<div class="post-user">{$text.$k|escape|esc|nl2br}</div>{/if}
                    </div>
                    {foreach from=$arrayrows item=rows key=ks}
                        {if $row.id == $rows.refid}
                            <div class="fon menu">  
                                <a href="{$home}/forum/{$row.id}/{$rows.id}"><i class="fa fa-commenting"></i>
                                    {$rows.name|esc}<span class="pull-right"> {$rows.counttema|number} / {$rows.countpost|number}</span></a>
                                {if $rows.text}<div class="post-user">{$texts.$ks|escape|esc|nl2br|bbcode}</div>{/if}
                            </div>
                        {/if}
                    {/foreach}
                </div>
                {if $user.level == 100}
                    <div class="breadcrumb">
                        <a href="{$home}/forum/setup/{$row.id}">Параметры</a> / 
                        <a href="{$home}/forum/setup/del/{$row.id}">Удалить</a> {if $count > 1} / {/if} 
                        {if $num > 1}<a href="{$home}/forum/setup/up/0/{$row.id}"  title="Переместить вверх"><i class="fa fa-arrow-up"></i></a>{/if}
                        {if $num != $count}<a href="{$home}/forum/setup/down/0/{$row.id}" title="Переместить вниз"><i class="fa fa-arrow-down"></i></a>{/if}
                    </div>
                {/if}
                <div class="margin-top-10"></div>
            {/foreach}
        {else}
            <div class="alert alert-danger">Разделы ещё не созданы...</div>
        {/if}
    </div>
{/if}