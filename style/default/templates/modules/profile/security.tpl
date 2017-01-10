<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">  
{if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
<form action="{$url}" method="post" class="fon">
    <p><label>Старый пароль:</label> <br/><input type="password" name="oldpass" value="{$smarty.post.oldpass}" class="form-control"/></p>
    <p><label>Новый пароль:</label> <br/><input type="password" name="newpass" value="{$smarty.post.newpass}" class="form-control"/></p>
    <p><label>Повторите ввод нового пароля:</label> <br/><input type="password" name="newpass_confirm" value="{$smarty.post.newpass_confirm}" class="form-control"/></p>
    <p><input type="submit" name="ok" value="Сохранить" class="btn btn-primary"></p>
</form>
</div>