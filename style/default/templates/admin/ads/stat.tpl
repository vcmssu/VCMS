<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/ads">{$title}</a> / Статистика рекламы {$row.link|esc}</div>
<div class="fon">
    {if $count > 0}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
            <br/>{/if}
            <span id="cat">
                <table class="table table-bordered table-striped table-condensed">
                    <tr>
                        <th style="text-align:center;"><b>IP</b></th>
                        <th style="text-align:center;"><b>Страна</b></th>
                        <th style="text-align:center;"><b>Город</b></th>
                        <th style="text-align:center;"><b>Браузер</b></th>
                        <th style="text-align:center;"><b>Регион</b></th>
                        <th style="text-align:center;"><b>Реферер</b></th>
                        <th style="text-align:center;"><b>Дата</b></th>
                    </tr>
                    {foreach from=$arrayrow item=row}
                        <tr>
                            <td style="text-align:center;">{$row.ip}</td>
                            <td style="text-align:center;">{$row.country}</td>
                            <td style="text-align:center;">{$row.city}</td>
                            <td style="text-align:center;">{$row.browser}</td>
                            <td style="text-align:center;">{$row.region}</td>
                            <td style="text-align:center;"><a href="{$row.referer}" target="_blank">{$row.referer|truncate:32}</a></td>
                            <td style="text-align:center;">{$row.time|times}</td>
                        </tr>
                    {/foreach}
                </table>
            </span>
            <br/>
            {*постраничка*} 
            {if $count > $message}
                <div class="paging_bootstrap pagination">{$pagenav}</div>
                <br/>{/if}
            {else}
                <div class="alert alert-danger">Переходов ещё не было!</div>
            {/if} 
        </div>