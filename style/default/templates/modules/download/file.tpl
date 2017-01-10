<div class="head"><a href="{$home}/download">Загрузки</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=file}
            <div class="list" id="{$file.id}">
                <a href="{$home}/download/{$file.id}-{$file.translate}" title="Перейти к файлу">{$file.name|esc}</a>
                <span class="pull-right">{$file.size}, просмотров: {$file.views|number}, скачиваний: {$file.loadcounts|number}</span>
                <p><a href="{$home}/download/load/{$file.id}">Скачать файл</a></p>
            </div>
        {/foreach} 
{if $count > $message}
    <div class="paging_bootstrap pagination">{$pagenav}</div>
{/if}        
    {else}
        <div class="alert alert-danger">Дополнительных файлов нет...</div>
    {/if}
    <h3>Загрузка файла в папку</h3>
{if isset($error_file)}<div class="alert alert-danger">{$error_file}</div>{/if}
{if isset($error_mass)}<div class="alert alert-danger">{$error_file}</div>{/if}
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
<form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
    <p><font color="red">*</font>Выберите файлы: <br/>                                    
        <input type="file" name="file[]" value="" class="form-control" multiple="" required/>
    </p>
    <h4>Дополнительные опции</h4>
    <p><label><input name="number" type="checkbox" value="1">&nbsp;Вырезать цифры из названия файла</label></p>
    <p><label><input name="simvol" type="checkbox" value="1">&nbsp;Вырезать спецсимволы из названия файла</label></p>
    <p><input type="submit" name="mass" value="Загрузить файлы" class="btn btn-primary"></p>
</form>        
</div>
<div class="menu"><a href="{$home}/download/{$row.id}-{$row.translate}"><i class="fa fa-angle-left"></i> К файлу {$row.name|escape|esc}</a></div>  