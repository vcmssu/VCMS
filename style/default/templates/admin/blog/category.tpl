<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/blog">{$title}</a> / Категории</div>
<div class="fon">
    {if $count > 0}
        {*постраничка*} 
        {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
        <span id="cat"><table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <tr>
                    <th style="text-align:center;"><b>Название </b></th>
                    <th style="text-align:center;"><b>Редактор </b></th>
                </tr>
                {foreach from=$arrayrow item=row}  
                    {counter name=num assign=num}
                    <tr>  
                        <td style="text-align:center;">{$row.name|esc|escape}</td>
                        <td style="text-align:center;">
                            {if $num > 1}<a href="{$home}{$panel}/blog/category/up/{$row.id}"  title="Переместить вверх"><i class="fa fa-arrow-up"></i></a>{/if}
                            {if $num != $count}<a href="{$home}{$panel}/blog/category/down/{$row.id}"  title="Переместить вниз"><i class="fa fa-arrow-down"></i></a>{/if} 
                            <a href="{$home}{$panel}/blog/category/edit/{$row.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                            <a href="{$home}{$panel}/blog/category/del/{$row.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                {/foreach}
            </table></span><br/>
            {*постраничка*} 
            {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
    {else}
        <div class="alert alert-danger">Категории ещё не созданы!</div>
    {/if}  
    <h3>Добавить категорию</h3>
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$home}{$panel}/blog/category" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font><label>Название категории:</label> <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
        <p>
            {include file='system/seo.tpl'}
            {$smarty.capture.add_seo}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>