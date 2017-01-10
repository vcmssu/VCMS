<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">
    <form action="{$home}{$panel}/setting" method="post" class="fon">
        <p><font color="red">*</font><label>Ссылка на главную страницу сайта:</label> <br/> <input type="text" class="form-control" name="home" value="{$setup.home|esc}" required/></p>
        <p><font color="red">*</font><label>Копирайт сайта:</label> <br/> <input type="text" class="form-control" name="copy" value="{$setup.copy|esc|escape:"html"}" required/></p>
        <p><font color="red">*</font><label>Название сайта:</label> <br/> <input type="text" class="form-control" name="namesite" value="{$setup.namesite|esc|escape:"html"}" required/></p>
        <p><font color="red">*</font><label>Ссылка на админку, слеш "/" в начале обязателен:</label> <br/> <input type="text" class="form-control" name="adminpanel" value="{$setup.adminpanel|esc}" required/></p>
        <p><label><input type="checkbox" name="adminlogs" value="1"{if $setup.adminlogs == 1} checked="check"{/if}/> Логирование действий администрации</label></p>
        <p><font color="red">*</font><label>Временная зона сайта:</label> <select class="form-control" name="timezone">
                {foreach from=$arrayrow item=zone}
                    <option value="{$zone.zone_name|esc}"{if $setup.timezone == $zone.zone_name|esc} selected="selected"{/if}>{$zone.zone_name|esc}</option>
                {/foreach}   
            </select></p>
        <p><font color="red">*</font><label>Тема оформления: </label>
            <select class="form-control" name="skin">
                {foreach from=$arrayrowskin item=skin}
                    {assign var="name" value="style/$skin/name.txt"}
                    <option value="{$skin}" {if $setup.skin == $skin}selected="selected"{/if}>{$name|file_get_contents}</option>
                {/foreach}
            </select>
        </p>
        <p><font color="red">*</font><label>Сжатие HTML:</label><br/>
            <label><input type="radio" name="compress" value="1"{if $setup.compress == 1} checked="check"{/if}> среднее (сжимается всё, кроме js скриптов)</label><br/>
            <label><input type="radio" name="compress" value="2"{if $setup.compress == 2} checked="check"{/if}> максимальное (весь исходный код отдаётся в 1 строчку, js не работает)</label><br/>
            <label><input type="radio" name="compress" value="3"{if $setup.compress == 3} checked="check"{/if}> отключено</label><br/>
        </p>
        <p><font color="red">*</font><label>E-mail администратора:</label> <br/> <input type="text" class="form-control" name="emailadmin" value="{$setup.emailadmin|esc}" required/></p>
        <p><font color="red">*</font><label>Антифлуд, в секундах:</label> <br/> <input type="text" class="form-control" name="antiflood" value="{$setup.antiflood|esc}" required/></p>
        <p><font color="red">*</font><label>Кол-во дней для автоматической очистки гостевой (0 - выключено):</label> <br/> <input type="text" class="form-control" name="autoclear_guest" value="{$setup.autoclear_guest|esc}" required/></p>
        <p><font color="red">*</font><label>Листинг для постраничной навигации:</label> <br/> <input type="text" class="form-control" name="message" value="{$setup.message|esc}" required/></p>	    
        <p><label>Ключевые слова, для поисковиков:</label> <br/> <textarea name="keywords" class="form-control"/>{$setup.keywords|esc}</textarea></p>
        <p><label>Описание сайта, для поисковиков:</label> <br/> <textarea name="description" class="form-control"/>{$setup.description|esc}</textarea></p>
        <input type="submit" name="submit" value="Сохранить настройки" class="btn btn-primary">
    </form>     
</div>