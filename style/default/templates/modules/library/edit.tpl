<div class="head"><a href="{$home}/library">Библиотека</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Название статьи: <br/> <input type="text" class="form-control" name="name" value="{$row.name|escape|esc}"/></p>
        <p>Автор: <br/> <input type="text" class="form-control" name="autor" value="{$row.autor|escape|esc}"/></p>
        <p><font color="red">*</font>Содержание статьи:<br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
            {if $user.level > 1}
                {include file='system/seo.tpl'}
                {$smarty.capture.edit_seo}
            {/if}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>
<div class="menu"><a href="{$home}/library/{$row.id}-{$row.translate}"><i class="fa fa-angle-left"></i> К статье {$row.name|escape|esc}</a></div>       