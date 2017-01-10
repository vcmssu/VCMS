<div class="box">
    <div class="box-b">
        <div class="box-title">{$title}</div>
        {if $setup.registration == 1}    
            {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
            <form action="{$url}" method="post" class="fon">
                <p>Логин: <br/><input type="text" name="login" value="{$smarty.post.login}" class="form-control"/></p>
                <p>E-mail: <br/><input type="email" name="email" value="{$smarty.post.email}" class="form-control"/></p>
                <p>Пароль: <br/><input type="password" name="password" value="{$smarty.post.password}" class="form-control"/></p>
                    {if $setup.captcha_signup == 1}
                        {include file='system/captcha.tpl'}
                    {/if}
                <p><input type="submit" name="ok" value="Зарегистрироваться" class="btn btn-primary"></p>
                <p>Уже зарегистрированы? <a href="{$home}/user/login">Войти</a></p>
            </form>
            {if $setup.activation == 1}<div class="alert alert-info">На Ваш e-mail будет отправлена ссылка для активации аккаунта.</div>{/if}
        {else}
            <div class="alert alert-danger">Регистрация на сайте отключена!</div>
        {/if}
    </div>
</div>