{include file='system/panel.tpl'}
<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$rows.id}">{$rows.name|escape|esc}</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}  
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Текст сообщения:<br/> 
            <textarea name="text"{if $smarty.session.device == 'web'} id="bbcode" rows="15"{/if} class="form-control">{if empty($smarty.post.text)}[b]{$row.login|escape|esc}[/b], {else}{$smarty.post.text}{/if}</textarea>
            {$smarty.capture.smile} 
        </p>
        <input type="hidden" name="reply" value="1">
        {$smarty.capture.add_file}
        {if $setup.captcha_add_post == 1}
            {include file='system/captcha.tpl'}
        {/if}
        <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
    </form>
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$rows.id}/{$tema.id}?page={$starts}#{$row.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|escape|esc}</a></div> 