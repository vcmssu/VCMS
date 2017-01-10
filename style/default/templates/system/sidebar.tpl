<div class="col-md-3 hidden-xs hidden-sm">
    {if $user.id}
        <div class="pod">
            <div class="head">{$user.login|esc}</div>
            <div class="foto"><img src="{$home}/files/{if $user.avatar}user/{$user.id}/{$user.avatar}{else}nophoto.jpg{/if}" class='img-responsive' /></div>
            <a href="{$home}/profile/my"><div class="menu2"><i class="fa fa-user"></i> Редактировать анкету</div></a>
        </div>
    {else}
        <div class="pod">
            <div class="head">Авторизация</div>
            <div class="fon">
                <form action="{$home}/user/login" method="post">
                    <input type="text" class="form-control" name="login" maxlength="30" value="" placeholder="Логин" required>
                    <input type="password" class="form-control" name="password" maxlength="30" placeholder="Пароль" required>
                    <input type="submit" name="ok" value="Войти" class="btn btn-primary btn-block">
                </form>
            </div>
            <a href="{$home}/user/signup"><div class="menu2"><i class="fa fa-user-plus"></i> Регистрация</div></a>
            <a href="{$home}/user/lostpass"><div class="menu2"> <i class="fa fa-key"></i> Забыли пароль ?</div></a>
        </div>
    {/if}
    <div class="pod">
        <div class="head">На сайте</div>
        <div class="menu"><a href="{$home}/online"><i class="fa fa-fire"></i> Пользователей: ({$usersonline|number})</a></div>
        <div class="menu"><a href="{$home}/online/guest"><i class="fa fa-fire"></i> Гостей: ({$guestonline|number})</a></div>
    </div>
    {if $lastthems && $smarty.server.REQUEST_URI == '/'}
        <div class="pod">
            <div class="head">Новые темы</div>
            {foreach from=$lastthems item=rows key=k}
                {math equation="max(0, z - ((( z % y) == 0) ? y : ( z % y)))" z=$rows.countpost y=$message assign="starts"}
                <div class="menu">
                    <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id}">{$rows.name|escape|esc} ({$rows.countpost})</a> 
                    <a href="{$home}/forum/{$rows.id_razdel}/{$rows.id_forum}/{$rows.id}?page={$starts}#{$rows.id_post_last}" title="Последнее сообщение"><i class="fa fa-angle-double-right"></i></a>
                    <a href="{$home}/id{$rows.id_user_last}">{$rows.login|escape|esc}</a>
                    <span>{$rows.time|times}</span>
                </div>
            {/foreach}
        </div>
    {/if}
    {if $smarty.server.REQUEST_URI != '/'}
        <div class="pod">
            <div class="head">Полезное</div>
            <div class="menu"><a href="{$home}/download"><i class="fa fa-download"></i> Загрузки ({$download|number}{if $downloadnew > 0} <font color="red">+{$downloadnew|number}</font>{/if})</a></div>    
        </div>
        <div class="pod">
            <div class="head">Общение</div>
            <div class="menu"><a href="{$home}/guest"><i class="fa fa-pencil-square"></i> Гостевая ({$guest|number})</a></div>
            <div class="menu"><a href="{$home}/blogs"><i class="fa fa-sticky-note"></i> Блоги ({$blog|number})</a></div>
            <div class="menu"><a href="{$home}/forum"><i class="fa fa-comments"></i> Форум ({$tema|number} / {$post|number})</a></div>
        </div>
        <div class="pod">
            <div class="head">Сообщество</div>
            <div class="menu"><a href="{$home}/users"><i class="fa fa-users"></i> Пользователи ({$users|number})</a></div>
            <div class="menu"><a href="{$home}/gallery"><i class="fa fa-picture-o"></i> Фотогалерея ({$gallery|number} / {$gallery_photo|number})</a></div>
        </div>
    {/if}
    {if $adsleft} 
        <div class="pod">
            <div class="head">Реклама</div>
            {foreach from=$adsleft item=left key=kleft}
                <div class="menu"><a href="{$home}/go/{$left.id}">{$left.text|escape|esc|bbcode}</a></div>
                {/foreach}
        </div>
    {/if}
</div> 