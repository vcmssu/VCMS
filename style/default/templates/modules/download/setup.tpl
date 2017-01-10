<div class="head"><a href="{$home}/download">Загрузки</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}
    <form action="{$home}/download/setup/{$row.id}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Название категории: <br/><input type="text" name="name" value="{$row.name|escape|esc}" class="form-control" required/></p>
        <p>Описание категории: <br/> <textarea name="text"{if $smarty.session.device == 'web'} rows="15"{/if} class="form-control bbcode"/>{$row.text|esc|escape}</textarea></p>
        <p>Иконка к категории: <br/><input type="file" name="icon" value="" class="form-control"/></p>
            {include file='system/seo.tpl'}
            {$smarty.capture.edit_seo}
        <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
    </form>
</div>