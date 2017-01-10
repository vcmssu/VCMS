<section id="main-content"{if $smarty.cookies.filteradmin == 1} class="merge-left"{/if}>
          <section class="wrapper site-min-height">
<section class="panel"><header class="panel-heading"><a href="{$home}{$panel}">Главная</a> / <a href="{$home}{$panel}/pages">{$title}</a> / Редактирование страницы {$row.name}</header>
    {if isset($error)}<div class="alert alert-danger">
        <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>{$error}</div>{/if}    
<form action="{$home}{$panel}/pages/edit/{$row.id}" method="post" enctype="multipart/form-data">
	<font color="red">*</font><label>Название страницы, отображается в заголовке:</label> <br/> <input type="text" class="form-control" name="name" value="{$row.name}" required/><br/><br/>
	<font color="red">*</font><label>Содержимое страницы:</label> <br/> <textarea name="text" id="text" class="form-control"/>{$row.text|esc}</textarea><br/><br/>
	<br/><input type="submit" name="ok" value="Отправить" class="btn">
</form>     
</section>    
          </section>
</section>
<script type="text/javascript" src="{$home}/js/ckeditor.js"></script> 