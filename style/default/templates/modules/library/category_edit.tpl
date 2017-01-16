<div class="head"><a href="{$home}/library">Библиотека</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Кто может писать в категорию?: <br/> 
            <select name="user" class="form-control">
                <option value="0"{if $row.user == 0} selected="selected"{/if}>Все</option>
                <option value="1"{if $row.user == 1} selected="selected"{/if}>Только администрация</option>
            </select>
        </p>
        <p><font color="red">*</font>Название категории: <br/> <input type="text" class="form-control" name="name" value="{$row.name|escape|esc}"/></p>
        <p>Описание категории:<br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
            {include file='system/seo.tpl'}
            {$smarty.capture.edit_seo}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>