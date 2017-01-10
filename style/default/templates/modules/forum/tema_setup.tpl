<div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|escape|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|escape|esc}</a> / {$title|escape}</div>
<div class="fon">
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font>Название темы: <br/> <input type="text" class="form-control" name="name" value="{$tema.name|escape|esc}"/></p>
        <p><font color="red">*</font>
            Выберите раздел:<br/>
            <select name="forum" class="form-control">
                {foreach from=$arrayrowr item=rowr}
                    <optgroup label="{$rowr.name|escape|esc}">   
                        {foreach from=$arrayrowp item=rowcat}
                            {if $rowr.id == $rowcat.refid}
                                <option value="{$rowcat.id}"{if $rowcat.id == $tema.id_forum} selected="selected"{/if}>{$rowcat.name|escape|esc}</option>
                            {/if}
                        {/foreach}
                    </optgroup>  
                {/foreach}   
            </select>
        </p>
        <p><font color="red">*</font>Позиция: <br/> <input type="text" class="form-control" name="realid" value="{$tema.realid|escape|esc}"/></p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form>
</div>
<div class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}"><i class="fa fa-angle-left"></i> К теме {$tema.name|escape|esc}</a></div> 