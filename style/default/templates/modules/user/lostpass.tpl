<div class="box">
    <div class="box-b">
        <div class="box-title">{$title}</div>
        {if isset($ok)}<div class="alert alert-success">{$ok}</div>{/if}    
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
        {if $smarty.post.ok && !isset($error)}<div class="alert alert-success">Ссылка для восстановления пароля успешно выслана на Ваш e-mail!</div>{/if}
        <form action="{$url}" method="post" class="links">
            <p>E-mail: <br/><input type="email" name="email" value="{$smarty.post.email}" class="form-control" required/></p>
            <p><input type="submit" name="ok" value="Восстановить пароль" class="btn btn-primary"></p>
            <p>Вспомнили свой пароль? <a href="{$home}/user/login">Войти</a></p>
        </form>
        <div class="alert alert-info">На Ваш e-mail будет отправлена ссылка для сброса пароля.</div>
    </div>
</div>