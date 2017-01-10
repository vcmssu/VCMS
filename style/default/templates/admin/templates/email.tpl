<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/templates">{$title}</a> / Шаблоны писем</div>
<div class="fon">
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона </b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        {foreach from=$arrayrowtemplate item=template}
            <tr><td style="text-align:center;">{$template}</td> 
                <td style="text-align:center;">   
                    <a href="{$home}{$panel}/templates/email/edit/{$setup.skin}/templates/mail/{$template}" title="Редактировать"><i class="fa fa-pencil"></i></a>
            </tr>
        {/foreach}
    </table>              
</div>