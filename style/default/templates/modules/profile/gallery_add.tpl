<div class="head"><a href="{$home}/profile">Мой кабинет</a> / <a href="{$home}/profile/gallery">Фотоальбомы</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}    
    <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
        <p><font color="red">*</font><label>Название альбома:</label> <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
        <p><label>Описание альбома:</label><br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.add_comments}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form> 
</div>