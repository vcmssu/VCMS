<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/users">Пользователи</a> / {$title}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
    <form action="{$url}" method="post" class="fon">
        <p><font color="red">*</font><label>Должность на сайте:</label> <br/>
            <select name="level" class="form-control">
                <option value="1"{if $row.level == 1} selected="selected"{/if}>пользователь</option>
                <option value="10"{if $row.level == 10} selected="selected"{/if}>младший модератор</option>
                <option value="20"{if $row.level == 20} selected="selected"{/if}>модератор</option>
                <option value="30"{if $row.level == 30} selected="selected"{/if}>старший модератор</option>
                <option value="40"{if $row.level == 40} selected="selected"{/if}>супер модератор</option>
                <option value="50"{if $row.level == 50} selected="selected"{/if}>заместитель администратора</option>
                <option value="100"{if $row.level == 100} selected="selected"{/if}>главный администратор</option>
            </select>
        </p>
        <p><font color="red">*</font><label>Логин:</label> <br/><input type="text" name="login" value="{$row.login|esc}" class="form-control"/></p>
        <p><label>Имя:</label> <br/><input type="text" name="firstname" value="{$row.firstname|esc}" class="form-control"/></p>
        <p><label>Фамилия:</label> <br/><input type="text" name="lastname" value="{$row.lastname|esc}" class="form-control"/></p>
        <p><label>Город:</label> <br/><input type="text" name="city" value="{$row.city|esc}" class="form-control"/></p>
        <p><font color="red">*</font><label>E-mail:</label> <br/><input type="text" name="email" value="{$row.email|esc}" class="form-control"/></p>
        <p><label>Телефон:</label> <br/><input type="text" name="phone" value="{$row.phone|esc}" class="form-control"/></p>
        <p><label>Skype:</label> <br/><input type="text" name="skype" value="{$row.skype|esc}" class="form-control"/></p>
        <p><label>ICQ:</label> <br/><input type="text" name="icq" value="{$row.icq|esc}" class="form-control"/></p>
        <p><label>Баллы:</label> <br/><input type="text" name="balls" value="{$row.balls|esc}" class="form-control"/></p>
        <p><label>О себе:</label> <br/><textarea name="about" class="form-control">{$row.about|esc}</textarea></p>
        <p><input type="submit" name="ok" value="Сохранить изменения" class="btn btn-primary"></p>
    </form>
</div>