<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">  
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
    <form action="{$home}{$panel}/users/signup" method="post" class="fon">
        <p><label><input type="checkbox" name="registration" value="1"{if $setup.registration == 1} checked="check"{/if}/> Регистрация активна</label></p>
        <p><label><input type="checkbox" name="activation" value="1"{if $setup.activation == 1} checked="check"{/if}/> Активация аккаунта по e-mail</label></p>
        <p><label><input type="checkbox" name="captcha_signup" value="1"{if $setup.captcha_signup == 1} checked="check"{/if}/> Каптча при регистрации</label></p>
        <p><label>Стоимость изменения логина (<small>в баллах</small>):</label> <br/><input type="text" name="login_edit" value="{$setup.login_edit|esc}" class="form-control"/></p>
        <p><input type="submit" name="ok" value="Сохранить" class="btn btn-primary"></p>
    </form>
    <div class="alert alert-info">Изменение логина пользователем будет доступно в следующей версии движка как и начисление баллов за определенные действия.</div>
</div>