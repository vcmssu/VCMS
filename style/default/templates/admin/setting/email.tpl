<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/setting">{$title}</a> / Настройка отправки писем</div>
<div class="fon">  
    <form action="{$home}{$panel}/setting/email" method="post" class="fon">
        <p><label><font color="red">*</font>Тип отправки писем:</label><br/>
            <label><input type="radio" name="sendmail" value="mail"{if $setup.sendmail == 'mail'} checked="check"{/if}> mail</label><br/>
            <label><input type="radio" name="sendmail" value="smtp"{if $setup.sendmail == 'smtp'} checked="check"{/if}> smtp</label><br/>
        </p>
        <h3>Настройки SMTP</h3>
        <p><label>SMTP порт:</label><br/> <input type="text" class="form-control" name="smtpport" value="{$setup.smtpport|esc}"/></p>
        <p><label>SMTP хост:</label><br/> <input type="text" class="form-control" name="smtphost" value="{$setup.smtphost|esc}"/></p>
        <p><label>Имя пользователя:</label><br/> <input type="text" class="form-control" name="smtpusername" value="{$setup.smtpusername|esc}"/></p>
        <p><label>Пароль:</label><br/> <input type="text" class="form-control" name="smtppassword" value="{$setup.smtppassword|esc}"/></p>
        <input type="submit" name="submit" value="Сохранить настройки" class="btn btn-primary">
    </form>
</div>