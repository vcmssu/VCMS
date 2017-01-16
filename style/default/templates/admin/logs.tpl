<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">  
    <div class="breadcrumb"><a href="{$home}{$panel}/logs/clear">Очистить логи</a></div>
    {if $count > 0}
        {*постраничка*} 
        {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
        <span id="cat"><table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <tr>
                    <th style="text-align:center;"><b>Пользователь </b></th>
                    <th style="text-align:center;"><b>Модуль </b></th>
                    <th style="text-align:center;"><b>Действие </b></th>
                    <th style="text-align:center;"><b>IP </b></th>
                    <th style="text-align:center;"><b>Браузер </b></th>
                    <th style="text-align:center;"><b>Дата </b></th>
                </tr>
                {foreach from=$arrayrow item=row key=k}    
                    {include file='system/user.tpl'}
                    <tr>  
                        <td style="text-align:center;"><a href="{$home}/id{$row.id_user}" title="Перейти в профиль">{$row.login|esc}</a></td>
                        <td style="text-align:center;">{$row.modul|esc}</td>
                        <td style="text-align:center;">{$smarty.capture.text}</td>
                        <td style="text-align:center;">{$row.ip|esc}</td>
                        <td style="text-align:center;">{$row.browser|esc}</td>
                        <td style="text-align:center;">{$row.time|times}</td>
                    </tr>
                {/foreach}
            </table></span><br/>
            {*постраничка*} 
            {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
    {else}
        <div class="alert alert-danger">Логов ещё нет!</div>
    {/if}    
</div>    