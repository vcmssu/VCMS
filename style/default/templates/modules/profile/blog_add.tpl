<div class="head"><a href="{$home}/profile">Мой кабинет</a> / <a href="{$home}/profile/blog">Мой блог</a> / {$title}</div>
<div class="fon">
    {if $arrayrow}
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
        <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
            <p><font color="red">*</font><label>Категория:</label>
                <select name="refid" class="form-control">
                    {foreach from=$arrayrow item=rows}
                        <option value="{$rows.id}">{$rows.name|esc|escape}</option>
                    {/foreach}
                </select>
            </p>
            <p><font color="red">*</font><label>Название поста:</label> <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
            <p><font color="red">*</font><label>Содержание поста:</label><br/> 
                {include file='system/panel.tpl'}
                {$smarty.capture.add_comments}
            </p>
            <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
        </form> 
    {else}
        <div class="alert alert-danger">Категории ещё не созданы...</div>
    {/if}
</div>