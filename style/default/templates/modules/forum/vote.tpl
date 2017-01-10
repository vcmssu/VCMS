<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|escape|esc}</a> / {$title|escape}</div>
<div class="fon">
    {if $tema.countvote == 0}
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}  
        <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
            <p><font color="red">*</font>Вопрос: <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
                {foreach from=$array item=reply}
                    {counter name=mum assign=num}
                <p>Ответ №{$num}:<br/><input type="text" class="form-control" name="reply[{$num}]" value="{$smarty.post.reply.$num}"/></p>
                {/foreach}
            <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
        </form>
    {else}
        <div class="alert alert-danger">Голосование уже создано!</div>
    {/if}
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|escape|esc}</a></div> 