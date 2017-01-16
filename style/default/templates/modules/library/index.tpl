{if $cat.id}
    <div class="head">{if !empty($pat)}<a href="{$home}/library">Библиотека</a> {foreach from=$pat item=pats name=puts}{if $smarty.foreach.puts.last}{$pats|strip_tags:false}{else}{$pats}{/if}{/foreach}{else}{$title}{/if}</div>
    <div class="fon">
        <div class="breadcrumb">
            <a href="{$home}/library/top">Топ статей</a> | <a href="{$home}/library/search">Поиск</a>
            {if $user.level == 100 && $countart == 0}
                <a class="pull-right" href="{$home}/library/add/{$cat.id}">Создать категорию</a>
            {/if}
        </div>
        {if $count == 0 && $cat.user == 0 && $user.level == 1 || $count == 0 && $user.level > 1}
            <div class="breadcrumb"><a href="{$home}/library/add/articles/{$cat.id}">Добавить статью</a></div>
        {/if}
        {if $count > 0}
            {foreach from=$arrayrow item=row}
                {counter name=num assign=num}
                <div class="list">
                    <a href="{$home}/library/{$row.id}"><i class="fa fa-book"></i> {$row.name|esc}<span class="pull-right"> {$row.count|number}</span></a>
                </div>
                {if $user.level == 100}
                    <div class="breadcrumb">
                        <a href="{$home}/library/category/edit/{$row.id}">Параметры</a> / 
                        <a href="{$home}/library/category/del/{$row.id}">Удалить</a>
                        {if $num > 1}/ <a href="{$home}/library/category/up/{$row.refid}/{$row.id}"  title="Переместить вверх"><i class="fa fa-arrow-up"></i></a>{/if}
                        {if $num != $count}/ <a href="{$home}/library/category/down/{$row.refid}/{$row.id}" title="Переместить вниз"><i class="fa fa-arrow-down"></i></a>{/if}
                    </div>
                {/if}
            {/foreach}
        {/if}
        {if $count == 0}
            {include file='system/library.tpl'}{*вывод списка статей*}
        {/if}
    </div>
{else}
    <div class="head">{$title}</div>
    <div class="fon">
        <div class="breadcrumb">
            <a href="{$home}/library/top">Топ статей</a> | <a href="{$home}/library/search">Поиск</a>
            {if $user.level == 100}
                <a class="pull-right" href="{$home}/library/add">Создать категорию</a>
            {/if}
        </div>
        {if $count > 0}
            {foreach from=$arrayrow item=row}
                {counter name=num assign=num}
                <div class="list">
                    <a href="{$home}/library/{$row.id}"><i class="fa fa-book"></i> {$row.name|esc}<span class="pull-right"> {$row.count|number}</span></a>
                </div>
                {if $user.level == 100}
                    <div class="breadcrumb">
                        <a href="{$home}/library/category/edit/{$row.id}">Параметры</a> / 
                        <a href="{$home}/library/category/del/{$row.id}">Удалить</a>
                        {if $num > 1}/ <a href="{$home}/library/category/up/0/{$row.id}"  title="Переместить вверх"><i class="fa fa-arrow-up"></i></a>{/if}
                        {if $num != $count}/ <a href="{$home}/library/category/down/0/{$row.id}" title="Переместить вниз"><i class="fa fa-arrow-down"></i></a>{/if}
                    </div>
                {/if}
            {/foreach}
        {else}
            <div class="alert alert-danger">Категории ещё не созданы...</div>
        {/if}
    </div>
{/if}