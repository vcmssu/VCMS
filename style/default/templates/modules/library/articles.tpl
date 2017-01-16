<div class="head"><a href="{$home}/library">Библиотека</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Название статьи: <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
        <p>Автор: <br/> <input type="text" class="form-control" name="autor" value="{$smarty.post.autor}"/></p>
        <p><font color="red">*</font>Содержание статьи:<br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.add_comments}
            {if $user.level > 1}
                {include file='system/seo.tpl'}
                {$smarty.capture.add_seo}
            {/if}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>