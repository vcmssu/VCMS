<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">
    {if $user.avatar}<img src="{$home}/files/user/{$user.id}/{$user.avatar}">{/if}    
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
    <form action="{$url}" method="post" class="fon" enctype="multipart/form-data">
        <p><label>Аватар:</label> <br/><input type="file" name="file" class="form-control"/></p>
        <p><label>Имя:</label> <br/><input type="text" name="firstname" value="{$user.firstname|escape|esc}" class="form-control"/></p>
        <p><label>Фамилия:</label> <br/><input type="text" name="lastname" value="{$user.lastname|escape|esc}" class="form-control"/></p>
        <p><label>Город:</label> <br/><input type="text" name="city" value="{$user.city|escape|esc}" class="form-control"/></p>
        <p><font color="red">*</font><label>E-mail:</label> <br/><input type="email" name="email" value="{$user.email|escape|esc}" class="form-control" required/></p>
        <p><label>Телефон:</label> <br/><input type="text" name="phone" value="{$user.phone|escape|esc}" class="form-control"/></p>
        <p><label>Skype:</label> <br/><input type="text" name="skype" value="{$user.skype|escape|esc}" class="form-control"/></p>
        <p><label>ICQ:</label> <br/><input type="text" name="icq" value="{$user.icq|escape|esc}" class="form-control"/></p>
        <p><label>О себе:</label> <br/><textarea name="about" class="form-control">{$user.about|escape|esc}</textarea></p>
        <p><input type="submit" name="ok" value="Сохранить" class="btn btn-primary"></p>
    </form>
</div>