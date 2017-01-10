<div class="head"><a href="{$home}/smiles">Список смайлов</a> / {$title}</div>
<div class="fon">
    {if $count > 0}
        <form action="{$smarty.server.REQUEST_URI}" method="post">
            <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <tr>
                    {if $user.id}<th style="text-align:center;"><b>Выбрать </b></th>{/if}
                    <th style="text-align:center;"><b>Изображение </b></th>
                    <th style="text-align:center;"><b>Код </b></th>
                </tr>
                {foreach from=$arrayrow item=rows}  
                    <tr>  
                        <td style="text-align:center;"><input type="checkbox" value="{$rows.id}" name="select[]"/></td>
                        <td style="text-align:center;"><img src="{$home}/files/smiles/{$rows.photo}"/></td>
                        <td style="text-align:center;">{$rows.code}</td>
                    </tr>
                {/foreach}
            </table> 
            <p><input type="submit" name="ok" value="Удалить" class="btn btn-primary"></p>
        </form>
        {*постраничка*} 
        {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
    {else}
        <div class="alert alert-danger">Смайлов ещё нет...</div>
    {/if} 
</div>
<div class="menu"><a href="{$smarty.session.referer}"><i class="fa fa-angle-left"></i> Вернуться назад</a></div>