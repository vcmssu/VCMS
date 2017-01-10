<section id="main-content"{if $smarty.cookies.filteradmin == 1} class="merge-left"{/if}>
          <section class="wrapper site-min-height">
<section class="panel"><header class="panel-heading"><a href="{$home}{$panel}">Главная</a> / {$title}</header>
{if $count > 0}
{*постраничка*} 
{if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
<span id="cat"><table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
			<tr>
                            <th style="text-align:center;"><b>Название </b></th>
                            <th style="text-align:center;"><b>Скопировать URL </b></th>
                            <th style="text-align:center;"><b>Дата добавления/изменения </b></th>
                            <th style="text-align:center;"><b>Редактор</b></th>
			</tr>
{foreach from=$arrayrow item=row}
<div class="modal fade" id="del{$row.id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">{$row.name}</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-error"><p>Вы уверены, что хотите удалить данную страницу?</p></div>
          <a href="{$home}{$panel}/pages/del/{$row.id}" class="btn style1">Да</a> <a href="#" class="btn style1" data-dismiss="modal" aria-hidden="true">Нет</a>
      </div>
    </div>
  </div>
</div>       
				<tr>  
                                <td style="text-align:center;"><a href="{$home}/pages/{$row.id}-{$row.translate}" title="Просмотреть страницу" target="_blank">{$row.name|esc}</a></td>
                                <td style="text-align:center;"><input type="text" value="{$home}/pages/{$row.id}-{$row.translate}"/></td>
                                <td style="text-align:center;">{$row.time|times}</td>
				<td style="text-align:center;">   
                                <a href="{$home}{$panel}/pages/edit/{$row.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#del{$row.id}" title="Удалить"><i class="fa fa-trash-o "></i></a></td>
                                </tr>
{/foreach}
</table></span><br/>
{*постраничка*} 
{if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
{else}
    <div class="alert alert-danger">Страницы ещё не добавлены!</div>
    {/if}    
</section>    
          </section>
</section>      