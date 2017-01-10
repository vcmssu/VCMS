<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|escape|esc}</a> / {$title|escape}</div>
<div class="fon">
    {if $tema.countvote == 1}
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}  
        <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
            <p><font color="red">*</font>Вопрос: <br/> <input type="text" class="form-control" name="name" value="{$tema.namevote|esc|escape}"/></p>
                {foreach from=$arrayrowvote item=vote}
                    {counter name=mum assign=num}
                <p>Ответ №{$num}:<br/><input type="text" class="form-control" name="reply[{$num}]" value="{$vote.name|esc|escape}"/></p>
                <input type="hidden" name="hidden[{$vote.id}]" value="{$vote.id}">
            {/foreach}
            {foreach from=$array item=reply}
                <p>Ответ №{$reply+1}:<br/><input type="text" class="form-control" name="reply[{$reply+1}]" value="{$smarty.post.reply.{$reply+1}}"/></p>
                {/foreach}
            <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
        </form>
    {else}
        <div class="alert alert-danger">Прежде чем редактировать голосование сначала его <a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/vote">создайте</a>!</div>
    {/if}
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|escape|esc}</a></div> 