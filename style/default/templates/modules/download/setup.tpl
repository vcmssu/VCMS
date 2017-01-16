<div class="head"><a href="{$home}/download">Загрузки</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}
    <form action="{$home}/download/setup/{$row.id}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Название категории: <br/><input type="text" name="name" value="{$row.name|escape|esc}" class="form-control" required/></p>
        <p>Описание категории: <br/> <textarea name="text"{if $smarty.session.device == 'web'} rows="15"{/if} class="form-control bbcode"/>{$row.text|escape|esc}</textarea></p>
        <p>Иконка к категории: <br/><input type="file" name="icon" value="" class="form-control"/></p>
        <p><label><input type="checkbox" name="user" value="1"{if $row.user == 1} checked="check"{/if}/> Загрузка файлов пользователями</label></p>
        <p><label><sup>1</sup>Типы файлов для загрузки, через запятую <small>(пример: png, jpg, gif, zip)</small>:</label> <br/><input type="text" name="type" value="{$row.type|escape|esc}" class="form-control"/></p>
        <p><label><sup>1</sup>Максимальный размер 1 файла для загрузки, в мб:</label> <br/><input type="text" name="maxfilesize" value="{$row.maxfilesize|escape|esc}" class="form-control"/></p>
            {include file='system/seo.tpl'}
            {$smarty.capture.edit_seo}
        <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
            <small><sup>1</sup> - типы файлов и максимальный размер 1 файла для загрузки нужно указывать только в том случае, если вы хотите открыть папку для загрузки файлов пользователями сайта</small>
    </form>
</div>