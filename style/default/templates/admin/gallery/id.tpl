<section id="main-content"{if $smarty.cookies.filteradmin == 1} class="merge-left"{/if}>
    <section class="wrapper site-min-height">
        <section class="panel"><header class="panel-heading"><a href="{$home}{$panel}">Главная</a> / <a href="{$home}{$panel}/gallery">{$title}</a> / Альбом {$rows.name|esc}</header>  
            <h3>Добавить фотографии</h3>  
                <form action="{$home}{$panel}/gallery/{$rows.id}" method="post" enctype="multipart/form-data">
                    <font color="red">*</font><label>Фотографии:</label> <br/> <input type="file" class="form-control" name="photo[]" multiple="true" accept="image/*" required/><br/><br/>
                    <br/><input type="submit" name="ok" value="Отправить" class="btn">
                </form><br/>
                {if $count > 0}  
                    {*постраничка*} 
                {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
            <span id="cat"><table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                    <tr>
                        <th style="text-align:center;"><b>Фото </b></th>
                        <th style="text-align:center;"><b>Редактор</b></th>
                    </tr>
                    {foreach from=$arrayrow item=row}
                        <div class="modal fade" id="del{$row.id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">{$row.photo|esc}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-danger"><p>Вы уверены, что хотите удалить данную фотографию?</p></div>
                                        <a href="{$home}{$panel}/gallery/del/photo/{$row.id}" class="btn style1">Да</a> <a href="#" class="btn style1" data-dismiss="modal" aria-hidden="true">Нет</a>
                                    </div>
                                </div>
                            </div>
                        </div>      
                        <tr>  
                            <td style="text-align:center;"><img src="{$home}/files/gallery/{$rows.id}/small_{$row.photo}"></td> 
                            <td style="text-align:center;">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#del{$row.id}" title="Удалить"><i class="fa fa-trash-o "></i></a></td>
                        </tr>
                    {/foreach}
                </table></span><br/>
                {*постраничка*} 
            {if $count > $message}<div class="paging_bootstrap pagination">{$pagenav}</div><br/>{/if}
    {else}
        <div class="alert alert-danger">Фотографии ещё не добавлены!</div>
    {/if}     
</section>    
</section>
</section> 