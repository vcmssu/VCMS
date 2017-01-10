<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">
    <div class="breadcrumb"><a href="{$home}{$panel}/ads/add">Добавить рекламу</a></div>
    {if $count > 0}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
            <br/>{/if}
            <span id="cat">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align:center;"><b>Ссылка</b></th>
                            <th style="text-align:center;"><b>Кол-во переходов</b></th>
                            <th style="text-align:center;"><b>Время, показы, переходы</b></th>
                            <th style="text-align:center;"><b>Место размещения</b></th>
                            <th style="text-align:center;"><b>Редактор</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$arrayrow item=row}
                            <tr>
                                <td style="text-align:center;">
                                    <a href="{$row.link|esc}" target="_blank">
                                        {$row.link|esc}
                                        <p>{$row.name|esc}</p>
                                    </a>
                                </td>
                                <td style="text-align:center;"><a href="{$home}{$panel}/ads/{$row.id}" title="Просмотреть статистику переходов">{$row.counts}</a></td>
                                <td style="text-align:center;">{if $row.time > $realtime}{$row.time|times}{/if}
                                    {if $row.count}переходов: {$row.count}{/if}
                                </td>
                                <td style="text-align:center;">
                                    {if $row.type == 'head_index'}вверху на главной странице{/if}
                                    {if $row.type == 'head'}вверху на всех страницах{/if}
                                    {if $row.type == 'head_no_index'}вверху на всех страницах, кроме главной{/if}
                                    {if $row.type == 'foot'}внизу на всех страницах{/if}
                                    {if $row.type == 'left'}слева на всех страницах{/if}
                                </td>
                                <td style="text-align:center;">
                                    <a href="{$home}{$panel}/ads/edit/{$row.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>    
                                    <a href="{$home}{$panel}/ads/del/{$row.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </span>
            <br/>
            {*постраничка*} 
            {if $count > $message}
                <div class="paging_bootstrap pagination">{$pagenav}</div>
                <br/>{/if}
            {else}
                <div class="alert alert-danger">Рекламы ещё нет!</div>
            {/if}
        </div>