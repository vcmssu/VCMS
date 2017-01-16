<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/users">Пользователи</a> / {$title}</div>
<div class="fon">
    <form action="{$url}" method="post" class="fon">
        <p><font color="red">*</font><label>Кол-во баллов за создание темы на форуме:</label> <br/><input type="text" name="balls_add_theme" value="{$setup.balls_add_theme|esc}" class="form-control"/></p>
        <p><font color="red">*</font><label>Кол-во баллов за добавление поста на форуме:</label> <br/><input type="text" name="balls_add_post" value="{$setup.balls_add_post|esc}" class="form-control"/></p>
        <p><font color="red">*</font><label>Кол-во баллов за создание поста в блоге:</label> <br/><input type="text" name="balls_add_blog" value="{$setup.balls_add_blog|esc}" class="form-control"/></p>
        <p><font color="red">*</font><label>Кол-во баллов за написание статьи в библиотеке:</label> <br/><input type="text" name="balls_add_library" value="{$setup.balls_add_library|esc}" class="form-control"/></p>
        <p><font color="red">*</font><label>Кол-во баллов за загруженный файл в ЗЦ:</label> <br/><input type="text" name="balls_add_download" value="{$setup.balls_add_download|esc}" class="form-control"/></p>
        <p><input type="submit" name="ok" value="Сохранить настройки" class="btn btn-primary"></p>
    </form>
</div>