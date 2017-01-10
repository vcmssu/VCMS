<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/ads">{$title}</a> / Добавление рекламы</div>
<div class="fon">
    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if} 
    <form action="{$url}" method="post" class="fon">
        <p><font color="red">*</font><label>Рекламная ссылка:</label><br/><input type="text" class="form-control" name="link" value="{$smarty.post.link}"/></p>
        <p><label>Название:</label><br/><input type="text" class="form-control" name="name" value="{$smarty.post.name}"/></p>
        <p><label>Время размещения рекламы:</label> 
            <input type="text" name="ch" style="width: 50px;" value="{$smarty.post.ch}"/>
            <select name="mn">
                <option value="1">Дней</option>
                <option value="7" selected="selected">Недель</option>
                <option value="31">Месяцев</option>
            </select>
        </p>            
        <p><label>Или кол-во переходов:</label><br/><input type="text" class="form-control" name="count" value="{$smarty.post.count}"/></p>
        <p><label>Место размещения рекламы:</label> 
            <select class="form-control" name="type">
                <option value="head_index">Вверху на главной странице</option>
                <option value="head_no_index">Вверху на всех страницах, кроме главной</option>
                <option value="head">Вверху на всех страницах</option>
                <option value="foot">Внизу на всех страницах</option>
                <option value="left">Слева на всех страницах (только в веб-версии)</option>
            </select>
        </p>
        <p><label><input type="checkbox" name="target" value="1" checked/> Открывать в отдельном окне</label></p>
        <p><font color="red">*</font><label>Рекламный материал:</label> <br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.add_comments}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form>
</div>