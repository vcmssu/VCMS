<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/sitemap">{$title}</a> / Robots.txt</div>
<div class="fon">
    <form action="{$home}{$panel}/sitemap/robots" method="post" class="fon">
        <textarea name="text" class="form-control" rows="25"/>{$template|escape}</textarea><br/>
        <input type="submit" name="ok" value="Сохранить" class="btn btn-primary"><br/><br/>
    </form>
{if $setup.compress != 3}<div class="alert alert-danger">Включёно сжатие HTML. Перед редактированием его рекомендуется <a href="{$home}{$panel}/setting">выключить</a>.</div>{/if} 
</div>
