<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">  
    {if $count > 0}
        {*постраничка*} 
        {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
        <span id="cat"><table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <tr>
                    <th style="text-align:center;"><b>Пользователь </b></th>
                    <th style="text-align:center;"><b>Действие </b></th>
                    <th style="text-align:center;"><b>Дата </b></th>
                </tr>
                {foreach from=$arrayrow item=rows key=k}  
                    {include file='system/user.tpl'}
                    <tr>  
                        <td style="text-align:center;"><a href="{$home}/id{$rows.id_user}" title="Перейти в профиль">{$rows.login|esc}</a></td>
                        <td style="text-align:center;">{$smarty.capture.text}</td>
                        <td style="text-align:center;">{$rows.time|times}</td>
                    </tr>
                {/foreach}
            </table></span><br/>
            {*постраничка*} 
            {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
    {else}
        <div class="alert alert-danger">Уведомлений ещё нет!</div>
    {/if}    
</div>    