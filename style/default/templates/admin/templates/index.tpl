<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название папки со стилями и шаблонами </b></th>
            <th style="text-align:center;"><b>Название шаблона</b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        {foreach from=$arrayrowskin item=skin}    
            {assign var="name" value="style/$skin/name.txt"}
            <tr><td style="text-align:center;">{$skin}</td> 
                <td style="text-align:center;">{$name|file_get_contents}</td> 
                <td style="text-align:center;">   
                    <a href="{$home}{$panel}/templates/view/{$skin}" title="Просмотреть"><i class="fa fa-pencil"></i></a>
                    <a href="{$home}{$panel}/templates/del/{$skin}" title="Удалить"><i class="fa fa-trash-o "></i></a>
            </tr>
        {/foreach}
    </table>
    <div class="alert alert-danger">Внимание: данный раздел предназначен только для специалистов и тех, кто разбирается в HTML и CSS! Все изменения в шаблоны 
        Вы вносите на свой страх и риск. Разработчик <a href="http://vcms.su" target="_blank" title="Открыть в новом окне">VCMS</a> за это ответственности не несёт.</div>    
{if $setup.compress != 3}<div class="alert alert-danger">Включёно сжатие HTML. Перед редактированием его рекомендуется <a href="{$home}{$panel}/setting">выключить</a>.</div>{/if} 
<h3>Загрузить новый шаблон</h3>
{if isset($error)}<div class="alert alert-danger">
        <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>{$error}</div>{/if}    
    <form action="{$home}{$panel}/templates" method="post" enctype="multipart/form-data" class="fon">
        <font color="red">*</font>Выбрать zip архив <input name="file" type="file" required/><br/><br/>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form>
</div>     