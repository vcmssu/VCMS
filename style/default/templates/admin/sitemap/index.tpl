<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">
    {if $arrayrow}
        <table class="table table-bordered table-striped table-condensed">
            <thead>
                <tr><th style="text-align:center;"><b>Название</b></th>
                    <th style="text-align:center;"><b>Ссылка</b></th>
                    <th style="text-align:center;"><b>Дата создания/изменения</b></th>
                    <th style="text-align:center;"><b>Редактор</b></th>
                </tr>
            </thead>
            {foreach from=$arrayrow item=row}                     
                <tr><td style="text-align:center;"><a href="{$home}/sitemap/{$row}" target="_blank">{$row}</a></td>
                    <td style="text-align:center;"><input type="text" value="{$home}/sitemap/{$row}" style="width:100%;"/></td>
                    <td style="text-align:center;">{$name|filectime|times}</td>
                    <td style="text-align:center;">
                        <a href="{$home}{$panel}/sitemap/edit/{$row}" title="Редактировать"><i class="fa fa-pencil "></i></a>
                        <a href="{$home}{$panel}/sitemap/del/{$row}" title="Удалить"><i class="fa fa-trash-o "></i></a>
                    </td>
                </tr>
            {/foreach}
        </table> 
    {if $setup.compress != 3}<div class="alert alert-danger">Включёно сжатие HTML. Перед редактированием его рекомендуется <a href="{$home}{$panel}/setting">выключить</a>.</div>{/if}        
{else}
    <div class="alert alert-danger">Карта сайта ещё не сгенерирована!</div>
{/if} 
</div>