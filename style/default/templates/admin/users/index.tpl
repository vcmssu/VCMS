<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">
    {if $count > 0}
        {*постраничка*} 
        {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
        <span id="cat"><table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <tr>
                    <th style="text-align:center;"><b>ID, логин </b></th>
                    <th style="text-align:center;"><b>Фамилия/имя </b></th>
                    <th style="text-align:center;"><b>Контакты </b></th>
                    <th style="text-align:center;"><b>Дата регистрации </b></th>
                    <th style="text-align:center;"><b>Последнее посещение </b></th>
                    <th style="text-align:center;"><b>Редактор </b></th>
                </tr>
                {foreach from=$arrayrow item=row}      
                    <tr>  
                        <td style="text-align:center;"><a href="{$home}/id{$row.id}" title="Перейти в профиль">{$row.id|esc}, {$row.login|esc}</a></td>
                        <td style="text-align:center;">{$row.firstname|esc} {$row.lastname|esc}</td>
                        <td style="text-align:center;">{$row.email|esc}{if $row.skype}<br/>skype - {$row.skype|esc}{/if}{if $row.icq}<br/>ICQ - {$row.icq|esc}{/if}</td>
                        <td style="text-align:center;">{$row.date_reg|times}</td>
                        <td style="text-align:center;">{$row.date_last|times}</td>
                        <td style="text-align:center;">
                            {if $row.ban == 0}
                                <a href="{$home}{$panel}/users/ban/{$row.id}" title="Забанить"><i class="fa fa-ban"></i></a>    
                                {else}
                                <a href="{$home}{$panel}/users/unban/{$row.id}" title="Разбанить"><i class="fa fa-universal-access"></i></a>  
                                {/if}
                            <a href="{$home}{$panel}/users/edit/{$row.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                            <a href="{$home}{$panel}/users/del/{$row.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                {/foreach}
            </table></span><br/>
            {*постраничка*} 
            {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
    {else}
        <div class="alert alert-danger">Пользователей ещё нет!</div>
    {/if} 
</div>