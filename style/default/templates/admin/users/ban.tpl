<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/users">Пользователи</a> / {$title}</div>
<div class="fon">
    {if $row.level < 100}
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
        <form action="{$url}" method="post" class="fon">
            <p><font color="red">*</font><label>Срок бана:</label> <br/>
                <input type="text" name="count" class="form-control"/>
                <select name="time" class="form-control">
                    <option value="1">дней</option>
                    <option value="7">недель</option>
                    <option value="31">месяцев</option>
                </select>
            </p>
            <p>Причина бана:<br/> 
                {include file='system/panel.tpl'}
                {$smarty.capture.add_comments}
            </p>
            <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
            {else}
            <div class="alert alert-danger">Вы не можете забанить главного администратора!</div>
        {/if}
    </form>
</div>