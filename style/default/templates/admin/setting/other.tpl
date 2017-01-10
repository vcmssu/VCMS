{assign var="highlight" value="js/codemirror/lib/codemirror.js"}
<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/setting">{$title}</a> / Дополнительные настройки</div>
<div class="fon">
    <form action="{$home}{$panel}/setting/other" method="post" class="fon">
        <p><label><input type="checkbox" name="guest" value="1"{if $setup.guest == 1} checked="check"{/if}/> В гостевую могут писать гости</label></p>
        <p><label><input type="checkbox" name="captcha_comments_news" value="1"{if $setup.captcha_comments_news == 1} checked="check"{/if}/> Каптча при добавлении комментария к новости</label></p>
        <p><label><input type="checkbox" name="captcha_comments_file" value="1"{if $setup.captcha_comments_file == 1} checked="check"{/if}/> Каптча при добавлении комментария к файлу</label></p>
        <p><label><input type="checkbox" name="captcha_comments_blog" value="1"{if $setup.captcha_comments_blog == 1} checked="check"{/if}/> Каптча при добавлении комментария к посту в блоге</label></p>
        {if $highlight|file_get_contents}<p><label><input type="checkbox" name="highlight" value="1"{if $setup.highlight == 1} checked="check"{/if}/> Подсветка кода в редакторе шаблонов</label></p>{/if}
        <p><font color="red">*</font><label>Максимальное ко-во отображаемых рекламных ссылок:</label> <br/> <input type="text" class="form-control" name="adslimit" value="{$setup.adslimit|esc}" required/></p>
        <p><font color="red">*</font><label>Размер превьюшки в фотогалерее, в пикселях (создаётся с сохранением пропорций):</label> <br/> <input type="text" class="form-control" name="gallerypreview" value="{$setup.gallerypreview|esc}" required/></p>
        <h3>Настройки каптчи</h3>
        <p><font color="red">*</font><label>Ширина:</label> <br/> <input type="text" class="form-control" name="captcha_width" value="{$setup.captcha_width|esc}" required/></p>
        <p><font color="red">*</font><label>Высота:</label> <br/> <input type="text" class="form-control" name="captcha_height" value="{$setup.captcha_height|esc}" required/></p>
        <p><font color="red">*</font><label>Размер шрифта:</label> <br/> <input type="text" class="form-control" name="captcha_font_size" value="{$setup.captcha_font_size|esc}" required/></p>
        <p><font color="red">*</font><label>Кол-во символов на картинке:</label> <br/> <input type="text" class="form-control" name="captcha_let_amount" value="{$setup.captcha_let_amount|esc}" required/></p>
        <p><font color="red">*</font><label>Кол-во символов на фоне:</label> <br/> <input type="text" class="form-control" name="captcha_let_amount_fon" value="{$setup.captcha_let_amount_fon|esc}" required/></p>
        <p><input type="submit" name="submit" value="Сохранить" class="btn btn-primary"></p>
    </form>    
</div>