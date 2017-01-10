<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">  
{if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
<form action="{$url}" method="post" class="fon">
    <p><label>Тема оформления:</label>
        <select class="form-control" name="skin">
            {foreach from=$arrayrowskin item=skin}
                {assign var="name" value="style/$skin/name.txt"}
                <option value="{$skin}" {if $user.skin == $skin}selected="selected"{/if}>{$name|file_get_contents}</option>
            {/foreach}
        </select></p>
    <p><label>Временная зона</label> <select class="form-control" name="timezone">
            {foreach from=$arrayrow item=zone}
                <option value="{$zone.zone_name|esc}"{if $user.timezone == $zone.zone_name|esc} selected="selected"{/if}>{$zone.zone_name|esc}</option>
            {/foreach}   
        </select></p>    
    <p><label>Кол-во сообщений на страницу (<small>от 5 до 100</small>):</label> <br/><input type="text" name="message" value="{$user.message|esc}" class="form-control"/></p>
    <p><label><input type="checkbox" name="news_send" value="1"{if $user.news_send == 1} checked="check"{/if}/> Подписка на новости</label></p>
    <p><input type="submit" name="ok" value="Сохранить" class="btn btn-primary"></p>
</form>
</div>