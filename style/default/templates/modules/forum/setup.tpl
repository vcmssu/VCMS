<div class="head"><a href="{$home}/forum">Форум</a>{if $forum.id} / <a href="{$home}/forum/{$forum.id}">{$forum.name|esc}</a>{/if} / {$title}</div>
<div class="fon">
{if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
<form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
    {if $row.refid == 0}<p><font color="red">*</font>Доступ: <br/> 
            <select name="type" class="form-control">
                <option value="0"{if $row.type == 0} selected="selected"{/if}>Всем</option>
                <option value="1"{if $row.type == 1} selected="selected"{/if}>Только авторизованным</option>
                <option value="2"{if $row.type == 2} selected="selected"{/if}>Только администрации</option>
            </select>
        </p>{/if}
        {if $row.refid > 0}
            <p>Переместить в раздел: <br/> <select name="forum" class="form-control" >
                {foreach from=$arrayrow item=rows}
                    <option value="{$rows.id}"{if $rows.id == $row.refid} selected="selected"{/if}>{$rows.name|esc}</option>
                {/foreach}
            </select></p>
        {/if}
        <p><font color="red">*</font>Название раздела: <br/> <input type="text" class="form-control" name="name" value="{$row.name|esc}"/></p>
        <p>Описание раздела:<br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
            {include file='system/seo.tpl'}
            {$smarty.capture.edit_seo}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>