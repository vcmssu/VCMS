<div class="head">{if !empty($pat)}<a href="{$home}/download">Загрузки</a> {foreach from=$pat item=pats name=puts}{if $smarty.foreach.puts.last}{$pats|strip_tags:false}{else}{$pats}{/if}{/foreach}{else}{$title}{/if}</div>
<div class="fon">
<div class="breadcrumb"><a href="{$home}/download/new">Новые файлы</a> | <a href="{$home}/download/top">Популярные</a> | <a href="{$home}/download/search">Поиск файлов</a></div>   
    {*категории*}
    {if !$id}
        {if $count > 0}
            {foreach from=$arrayrow item=row}
                {counter name=num assign=num}
                <div class="list">  
                    <a href="{$home}/download/{$row.id}">
                        {*иконка к папке/подпапке*}
                        {if $row.icon}
                            <img src="{$home}/{$row.path}{$row.icon}" alt="{$row.name|escape|esc}" />
                        {else}
                            <i class="fa fa-folder-open"></i>
                        {/if} 
                        {$row.name|escape|esc} <span class="pull-right">{$row.count|number}{if $row.countnew > 0} <font color="red">+{$row.countnew|number}</font>{/if}</span></a>
                    {if $row.text}<div class="post-user">{$row.text|escape|esc|nl2br|bbcode}</div>{/if}
                </div>
                {if $user.level > 40}
                    <div class="breadcrumb">
                        <a href="{$home}/download/setup/{$row.id}">Параметры категории</a> / 
                        <a href="{$home}/download/setup/del/{$row.id}">Удалить</a> 
                        {if $num > 1}/ <a href="{$home}/download/setup/up/0/{$row.id}"  title="Переместить вверх"><i class="fa fa-arrow-up"></i></a>{/if}
                        {if $num != $count}/ <a href="{$home}/download/setup/down/0/{$row.id}" title="Переместить вниз"><i class="fa fa-arrow-down"></i></a>{/if}
                    </div>
                {/if}
            {/foreach}
            {if $count > $message}
                <div class="paging_bootstrap pagination">{$pagenav}</div>
            {/if}
        {else}
            <div class="alert alert-danger">Категории ещё не созданы...</div>
        {/if}
    {else}
        {*категории*}
        {if $count > 0}
            {if $user.level > 40}
                <div class="breadcrumb">
                    <a href="{$home}/download/setup/{$id}">Параметры категории</a> / 
                    <a href="{$home}/download/setup/del/{$id}">Удалить</a>
                </div>
            {/if}
            {foreach from=$arrayrow item=row}
                {counter name=num assign=num}
                <div class="list">  
                    <a href="{$home}/download/{$row.id}">
                        {*иконка к папке/подпапке*}
                        {if $row.icon}
                            <img src="{$home}/{$row.path}{$row.icon}" alt="{$row.name|escape|esc}" />
                        {else}
                            <i class="fa fa-folder-open"></i>
                        {/if} 
                        {$row.name|escape|esc} <span class="pull-right">{$row.count|number}{if $row.countnew > 0} <font color="red">+{$row.countnew|number}</font>{/if}</span></a>
                </div>
                {if $user.level > 40}
                    <div class="breadcrumb">
                        <a href="{$home}/download/setup/{$row.id}">Параметры категории</a> / 
                        <a href="{$home}/download/setup/del/{$row.id}">Удалить</a>
                        {if $num > 1}/ <a href="{$home}/download/setup/up/{$row.refid}/{$row.id}"  title="Переместить вверх"><i class="fa fa-arrow-up"></i></a>{/if}
                        {if $num != $count}/ <a href="{$home}/download/setup/down/{$row.refid}/{$row.id}" title="Переместить вниз"><i class="fa fa-arrow-down"></i></a>{/if}
                    </div>
                {/if}
            {/foreach}
            {if $count > $message}
                <div class="paging_bootstrap pagination">{$pagenav_category}</div>
            {/if}   
        {/if}
        {*загрузка файлов*}		
        {if $count == 0}
            {if $user.level > 40}
                <div class="breadcrumb right">
                    <a href="{$home}/download/setup/{$id}">Параметры категории</a> / 
                    <a href="{$home}/download/setup/del/{$id}">Удалить</a>
                </div>
            {/if}
            {if isset($error_file)}
                <div class="alert alert-danger">{$error_file}</div>
            {/if}
            {if isset($error_mass)}
                <div class="alert alert-danger">{$error_file}</div>
            {/if}
            {include file='system/download.tpl'}{*вывод списка файлов*}
            {if $user.level > 40}
                <div class="margin-top-10"></div>
                <div class="fon">    
                    {if isset($error_file)}<div class="alert alert-danger">{$error_file}</div>{/if}
                    {if isset($error_mass)}<div class="alert alert-danger">{$error_file}</div>{/if}
                    <h3>Загрузка файла в папку</h3>
                    <form action="{$url}" method="post" enctype="multipart/form-data" class="links">
                        <p>Название файла (если название не указано, то оно будет взято из названия файла):<br/><input type="text" name="names" value="{$smarty.post.names}" class="form-control"/></p>
                        <p><font color="red">*</font>Выберите файл:<br/>                                    
                            <input type="file" name="file" value="" class="form-control" required/>
                        </p>
                        <p>Выберите скриншот (не обязательно): <small><span>типы файлов для загрузки - png, jpg, jpeg, gif</span></small><br/>
                            <input type="file" name="screen" value="" class="form-control"/>
                        </p>
                        <p>Описание файла:<br/><textarea name="text"{if $smarty.session.device == 'web'} id="bbcode" rows="15"{/if} class="form-control"/>{$smarty.post.text}</textarea></p>
                        <h4>Дополнительные опции</h4>
                        <p><label><input name="number" type="checkbox" value="1">&nbsp;Вырезать цифры из названия файла</label></p>
                        <p><label><input name="simvol" type="checkbox" value="1">&nbsp;Вырезать спецсимволы из названия файла</label></p>
                                {include file='system/seo.tpl'}
                                {$smarty.capture.add_seo}
                        <p><input type="submit" name="upload" value="Загрузить файл" class="btn btn-primary"></p>
                    </form>
                    <h3>Массовая загрузка файлов в папку</h3>
                    <form action="{$url}" method="post" enctype="multipart/form-data" class="links">
                        <p><font color="red">*</font>Выберите файлы: <br/>                                    
                            <input type="file" name="file[]" value="" class="form-control" multiple="" required/>
                        </p>
                        <h4>Дополнительные опции</h4>
                        <p><label><input name="number" type="checkbox" value="1">&nbsp;Вырезать цифры из названия файла</label></p>
                        <p><label><input name="simvol" type="checkbox" value="1">&nbsp;Вырезать спецсимволы из названия файла</label></p>
                        <p><input type="submit" name="mass" value="Загрузить файлы" class="btn btn-primary"></p>
                    </form>
                </div>
                <div class="margin-top-10"></div>
            {/if}
        {/if}
    {/if}
    {if $count_files == 0 && $user.level > 40}
        {*создание категорий*}
        {if isset($error)}
            <div class="alert alert-danger">{$error}</div>
        {/if}
        <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
            <p><font color="red">*</font>Название категории: <br/><input type="text" name="name" value="{$smarty.post.name}" class="form-control" required/></p>
            <p>Описание категории: <br/> <textarea name="text"{if $smarty.session.device == 'web'} rows="15"{/if} class="form-control bbcode"/>{$smarty.post.text}</textarea></p>
            <p>Иконка к категории: <br/><input type="file" name="icon" value="" class="form-control"/></p>
                {include file='system/seo.tpl'}
                {$smarty.capture.add_seo}
            <p><input type="submit" name="ok" value="Создать категорию" class="btn btn-primary"></p>
        </form>
    {/if}
</div>