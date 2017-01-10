<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/ads">{$title}</a> / Редактирование рекламы {$row.link|esc}</div>
<div class="fon">
    {if isset($error)}
        <div class="alert alert-error">{$error}</div>
    {/if}
    <form action="{$url}" method="post" class="fon">
        <p><label>Рекламная ссылка:</label><br/><input type="text" class="form-control" name="link" value="{$row.link|esc}"/></p>
        <p><label>Название:</label><br/><input type="text" class="form-control" name="name" value="{$row.name|esc}"/></p>
        <p><label>Продлить время размещения рекламы:</label>  
        <input type="text" name="ch" style="width: 50px;" value="{$smarty.post.ch}"/>
        <select name="mn">
            <option value="1">Дней</option>
            <option value="7" selected="selected">Недель</option>
            <option value="31">Месяцев</option>
        </select>
        </p>             
        <p><label>Или кол-во переходов:</label><br/><input type="text" class="form-control" name="count" value="{$row.count}"/></p>
        <p><label>Место размещения рекламы:</label> <select class="form-control" name="type">
                <option value="head_index"{if $row.type == 'head_index'} selected="selected"{/if}>Вверху на главной странице</option>
                <option value="head_no_index"{if $row.type == 'head_no_index'} selected="selected"{/if}>Вверху на всех страницах, кроме главной</option>
                <option value="head"{if $row.type == 'head'} selected="selected"{/if}>Вверху на всех страницах</option>
                <option value="foot"{if $row.type == 'foot'} selected="selected"{/if}>Внизу на всех страницах</option>
                <option value="left"{if $row.type == 'left'} selected="selected"{/if}>Слева на всех страницах (только в веб-версии)</option>
            </select></p>
        <p><label><input type="checkbox" name="target" value="1"{if $row.target == 1} checked{/if}/> Открывать в отдельном окне</label></p>
        <p><label>Рекламный материал:</label> <br/> 
            {include file='system/panel.tpl'}
            {$smarty.capture.edit_comments}
        </p>
        <input type="submit" name="ok" value="Отправить" class="btn btn-primary">
    </form>
</div>