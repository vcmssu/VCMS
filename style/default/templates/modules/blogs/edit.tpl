<div class="head"><a href="{$home}/blogs">Блоги</a> / <a href="{$home}/blogs/{$row.refid}">{$row.namecat|esc|escape}</a> / <a href="{$home}/blogs/{$row.refid}/{$row.id}-{$row.translate}">{$row.name|esc|escape}</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font><label>Категория:</label>
            <select name="refid" class="form-control">
                {foreach from=$arrayrow item=rows}
                    <option value="{$rows.id}"{if $rows.id == $row.refid} selected="selected"{/if}>{$rows.name|esc|escape}</option>
                {/foreach}
            </select>
        </p>
        <p><font color="red">*</font><label>Название поста:</label> <br/> <input type="text" class="form-control" name="name" value="{$row.name|esc|escape}"/></p>
        <p><font color="red">*</font><label>Содержание поста:</label><br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form>
</div>