<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="HandheldFriendly" content="true">
        <meta name="MobileOptimized" content="width">
        <meta name="keywords" content="{if $keywords}{$keywords|esc|strip_tags:false}{else}{$setup.keywords|esc|strip_tags:false}{/if}">
        <meta name="description" content="{if $description}{$description|esc|strip_tags:false}{else}{$setup.description|esc|strip_tags:false}{/if}">
        <meta name="author" content="VCMS, http://vcms.su">
        <meta name="generator" content="VCMS, http://vcms.su">
        <title>{$title}</title>
        <link rel="shortcut icon" href="{$home}/style/{$skin}/images/favicon.ico" />
        <link rel="stylesheet" href="{$home}/style/{$skin}/css/bootstrap.min.css">
        <link rel="stylesheet" href="{$home}/style/{$skin}/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{$home}/style/{$skin}/css/style.css">
        <script src="{$home}/style/{$skin}/js/jquery.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="{$home}"><i class="fa fa-home"></i></a> 
                        </div>
                    </div>
                    <div class="col-xs-10 clearfix">
                        <div class="pull-right">
                            <ul class="nav navbar-nav">
                                {if $user.id}
                                    {if $user.level == 100}
                                        <li><a href="{$home}{$panel}">Админка</a></li>
                                        {/if}
                                    <li><a href="{$home}/profile">Мой кабинет</a></li>
                                    <li><a href="{$home}/user/exit">Выход</a></li>
                                    {else}
                                        {if $setup.registration == 1}
                                        <li><a href="{$home}/user/login">Вход</a></li>
                                        <li><a href="{$home}/user/signup">Регистрация</a></li>
                                        {/if}
                                    {/if}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav> 
        <div class="container-fluid">
            {if $smarty.server.REQUEST_URI == '/' && $adsheadindex} 
                <div class="list hidden-xs hidden-sm">
                    {foreach from=$adsheadindex item=headindex key=kheadindex}
                        <p><a href="{$home}/go/{$headindex.id}">{$headindex.text|escape|esc|bbcode}</a></p>
                        {/foreach}
                </div>
            {/if}

            {if $smarty.server.REQUEST_URI != '/' && $adsheadnoindex} 
                <div class="list hidden-xs hidden-sm">
                    {foreach from=$adsheadnoindex item=headnoindex key=kheadnoindex}
                        <p><a href="{$home}/go/{$headnoindex.id}">{$headnoindex.text|escape|esc|bbcode}</a></p>
                        {/foreach}
                </div>
            {/if}
            {if $adshead} 
                <div class="list hidden-xs hidden-sm">
                    {foreach from=$adshead item=head key=khead}
                        <p><a href="{$home}/go/{$head.id}">{$head.text|escape|esc|bbcode}</a></p>
                        {/foreach}
                </div>
            {/if}
            <div class="row">
                {include file='system/sidebar.tpl'} 
                <div class="col-md-9">
                    {if $user.id}
                        {if $newnotice > 0}<div class="alert alert-info"><a href="{$home}/profile/notice"><i class="fa fa-bell"></i> Уведомления: {$newnotice}</a></div>{/if}
                        {if $newmail > 0}<div class="alert alert-warning"><a href="{$home}/profile/mail"><i class="fa fa-envelope"></i> Сообщения: {$newmail}</a></div>{/if}
                    {/if}
                    {if $smarty.server.REQUEST_URI == '/' && $adsheadindex} 
                        <div class="list visible-xs visible-sm">
                            {foreach from=$adsheadindex item=headindex key=kheadindex}
                                <p><a href="{$home}/go/{$headindex.id}">{$headindex.text|escape|esc|bbcode}</a></p>
                                {/foreach}
                        </div>
                    {/if}

                    {if $smarty.server.REQUEST_URI != '/' && $adsheadnoindex} 
                        <div class="list visible-xs visible-sm">
                            {foreach from=$adsheadnoindex item=headnoindex key=kheadnoindex}
                                <p><a href="{$home}/go/{$headnoindex.id}">{$headnoindex.text|escape|esc|bbcode}</a></p>
                                {/foreach}
                        </div>
                    {/if}
                    {if $adshead} 
                        <div class="list visible-xs visible-sm">
                            {foreach from=$adshead item=head key=khead}
                                <p><a href="{$home}/go/{$head.id}">{$head.text|escape|esc|bbcode}</a></p>
                                {/foreach}
                        </div>
                    {/if}