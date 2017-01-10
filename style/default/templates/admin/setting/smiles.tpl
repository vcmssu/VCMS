<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/setting">{$title}</a> / Смайлы</div>
<div class="menu"><a href="{$home}{$panel}/setting/smiles/update">Обновить базу смайлов ({$count|number})</a></div>
<div class="fon">
    {if $count > 0}
        {*постраничка*} 
        {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
        <span id="cat"><table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <tr>
                    <th style="text-align:center;"><b>Изображение </b></th>
                    <th style="text-align:center;"><b>Код </b></th>
                </tr>
                {foreach from=$arrayrow item=rows}  
                    <tr>  
                        <td style="text-align:center;"><img src="{$home}/files/smiles/{$rows.photo}"/></td>
                        <td style="text-align:center;">{$rows.code}</td>
                    </tr>
                {/foreach}
            </table></span><br/>
            {*постраничка*} 
            {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
    {else}
        <div class="alert alert-danger">Смайлов ещё нет!</div>
    {/if} 
</div>