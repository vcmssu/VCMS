<div class="head"><a href="{$home}/download">Загрузки</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Название файла:<br/><input type="text" name="name" value="{$row.name|escape|esc}" class="form-control"/></p>
        <p>Кол-во скачиваний:<br/><input type="text" name="loadcounts" value="{$row.loadcounts|escape|esc}" class="form-control"/></p>
        <p>Кол-во просмотров:<br/><input type="text" name="views" value="{$row.views|escape|esc}" class="form-control"/></p>
        <p>Новый файл:<br/>                                    
            <input type="file" name="file" value="" class="form-control"/>
        </p>
        <p>Выберите скриншот (не обязательно): <small><span>типы файлов для загрузки - png, jpg, jpeg, gif</span></small><br/>
            <input type="file" name="screen" value="" class="form-control"/>
        </p>
        {if $row.screen}
            <p><label><input type="checkbox" name="del" value="1"/> Удалить скриншот</label></p>   
                {/if}
        <p>Описание файла:<br/>
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
        </p>
        {include file='system/seo.tpl'}
        {$smarty.capture.edit_seo}
        <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
    </form>
</div>
<div class="menu"><a href="{$home}/download/{$row.id}-{$row.translate}"><i class="fa fa-angle-left"></i> К файлу {$row.name|escape|esc}</a></div>         