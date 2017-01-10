<div class="box">
    <div class="box-b">
        <div class="box-title">{$title}</div>
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
        <form action="{$url}" method="post" class="links">
            <p>Логин: <br/><input type="text" name="login" value="{$smarty.post.login}" class="form-control" required/></p>
            <p>Пароль: <br/><input type="password" name="password" value="{$smarty.post.password}" class="form-control" required/></p>
            <p><input type="submit" name="ok" value="Авторизоваться" class="btn btn-primary"></p>
            <p>Забыли пароль? <a href="{$home}/user/lostpass">Восстановить</a></p>
        </form>
    </div>
</div>