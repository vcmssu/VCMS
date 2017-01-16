<div class="head">{$title}</div>
<div class="fon">
    <div class="pod">
        <div class="head">Общение</div>
        <div class="menu"><a href="{$home}/profile/mail"><i class="fa fa-envelope"></i> Почта ({$mail|number}{if $newmail} <font color="red">+{$newmail|number}</font>{/if})</a></div>
        <div class="menu"><a href="{$home}/profile/friends"><i class="fa fa-users"></i> Друзья ({$friends|number}{if $friendsnew > 0} <font color="red"> +{$friendsnew|number}</font>{/if})</a></div>
        <div class="menu"><a href="{$home}/profile/blog"><i class="fa fa-book"></i> Блог ({$blog_user|number})</a></div>
        <div class="menu"><a href="{$home}/profile/library"><i class="fa fa-file-text"></i> Статьи ({$library_user|number})</a></div>
        <div class="menu"><a href="{$home}/profile/files"><i class="fa fa-file"></i> Файлы ({$files_user|number})</a></div>
        <div class="menu"><a href="{$home}/profile/gallery"><i class="fa fa-picture-o"></i> Фотоальбомы ({$gallery_user|number} / {$gallery_photo_user|number})</a></div>
        <div class="menu"><a href="{$home}/profile/notice"><i class="fa fa-neuter"></i> Уведомления ({$notice|number})</a></div>
    </div>
    <div class="pod">
        <div class="head">Личное</div>
        <div class="menu"><a href="{$home}/profile/my"><i class="fa fa-user"></i> Анкета</a> | <a href="{$home}/id{$user.id}"> Просмотреть</a></div>
        <div class="menu"><a href="{$home}/profile/setup"><i class="fa fa-user-secret"></i> Мои настройки</a></div>
        <div class="menu"><a href="{$home}/profile/security"><i class="fa fa-lock"></i> Настройки безопасности</a></div>
        <div class="menu"><a href="{$home}/profile/bookmark"><i class="fa fa-bookmark"></i> Закладки ({$bookmark|number})</a></div>
        <div class="menu"><a href="{$home}/profile/blacklist"><i class="fa fa-black-tie"></i> Черный список ({$blacklist|number})</a></div>
        <div class="menu"><a href="{$home}/profile/history"><i class="fa fa-history"></i> История авторизаций ({$history|number})</a></div>
    </div>
    <div class="pod">
        <div class="head">Информация</div>
        <div class="menu">Баллов: {$user.balls|number}</div>
        <div class="menu">Дата регистрации: {$user.date_reg|times}</div>
    </div>
</div>