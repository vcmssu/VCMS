<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/users">Пользователи</a> / {$title}</div>
<div class="fon">
    {if $row.level < 100}
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if}
        <form action="{$url}" method="post" class="fon">
            <div class="alert alert-danger">Вы уверены, что хотите удалить данного пользователя? Вместе с ним с сайта будет удалена вся информация, которую оставил пользователь, включая текстовые сообщения и файлы. Восстановить удаленные данные будет невозможно!</div>
            <p><label><input type="checkbox" name="optimize" value="1"/> Оптимизировать таблицы после удаления</label></p>
            <p><input type="submit" name="ok" value="Удалить" class="btn btn-primary"> <input type="submit" name="close" value="Отмена" class="btn btn-primary"></p>
            {else}
            <div class="alert alert-danger">Вы не можете удалить главного администратора!</div>
        {/if}
    </form>
</div>