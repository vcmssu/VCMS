<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/sitemap">{$title}</a> / Редактирование {$file}</div>
<div class="fon">        
    {if isset($error)}<div class="alert alert-danger">
            <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>{$error}</div>
            {else}
        <form action="{$home}{$panel}/sitemap/edit/{$file}" method="post" class="fon">
            <textarea class="form-control" rows="25" name="text"/>{$template|escape}</textarea><br/>
            <input type="submit" name="ok" value="Сохранить" class="btn btn-primary"><br/><br/>
        </form>	
    {/if} 
{if $setup.compress != 3}<div class="alert alert-danger">Включёно сжатие HTML. Перед редактированием его рекомендуется <a href="{$home}{$panel}/setting">выключить</a>.</div>{/if} 
</div>