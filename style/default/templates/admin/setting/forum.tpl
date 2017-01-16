<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/setting">{$title}</a> / Настройки форума</div>
<div class="fon">  
    <form action="{$home}{$panel}/setting/forum" method="post" class="fon">
        <p><label><input type="checkbox" name="captcha_add_theme" value="1"{if $setup.captcha_add_theme == 1} checked="check"{/if}/> Каптча при создании новой темы</label></p>
        <p><label><input type="checkbox" name="captcha_add_post" value="1"{if $setup.captcha_add_post == 1} checked="check"{/if}/> Каптча при добавлении поста (при ответе на пост и цитировании тоже)</label></p>
        <p><label><font color="red">*</font>Типы файлов для загрузки:</label><br/> <input type="text" class="form-control" name="filetype_forum" value="{$setup.filetype_forum|esc}"/></p>
        <p><label><font color="red">*</font>Максимальный размер 1 файла для загрузки, в мб:</label><br/> <input type="text" class="form-control" name="filesize_forum" value="{$setup.filesize_forum|esc}"/></p>
        <p><label><font color="red">*</font>Разрешенное кол-во файлов к 1 посту:</label><br/> <input type="text" class="form-control" name="filecount_forum" value="{$setup.filecount_forum|esc}"/></p>
        <p><label><font color="red">*</font>Время, по истечение которого темы и посты не будут считаться новыми, в секундах:</label><br/> <input type="text" class="form-control" name="time_forum" value="{$setup.time_forum|esc}"/></p>
        <p><label><font color="red">*</font>Кол-во вариантов ответов при голосовании:</label><br/> <input type="text" class="form-control" name="vote_forum" value="{$setup.vote_forum|esc}"/></p>
        <p><label><font color="red">*</font>Кол-во новых тем на главной странице:</label><br/> <input type="text" class="form-control" name="lastthems" value="{$setup.lastthems|esc}"/></p>
        <p><label><font color="red">*</font>Время для изменения своего поста пользователем, в минутах:</label><br/> <input type="text" class="form-control" name="forum_time_edit_post" value="{$setup.forum_time_edit_post|esc}"/></p>
        <input type="submit" name="submit" value="Сохранить настройки" class="btn btn-primary">
    </form>
    <p>* Типы файлов, максимальный размер 1 файла для загрузки и разрешенное кол-во файлов используются также в модуле личных сообщений.</p>  
</div>