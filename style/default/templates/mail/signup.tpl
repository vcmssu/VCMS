<p>Здравствуйте, {$login}!</p>
<p>Спасибо за регистрацию на нашем сайте <a href="{$home}">{$setup.namesite}</a>.</p>
{if $setup.activation == 1}
    <p>Чтобы завершить процесс регистрации, нажмите на ссылку <a href="{$home}/user/activation/{$fid}/{$activation}">Активировать учётную запись</a></p>
    <p>Если ссылка не активна, то скопируйте её в браузерную строку - {$home}/user/activation/{$fid}/{$activation}</p>
{/if}
<p>Для входа используйте логин и пароль, высланные на Ваш e-mail:</p>
<p>Логин: {$login}<br>
    Пароль: {$pass}
</p>
<br/><br/><br/>
<p>--<br/>
    С уважением, администрация ресурса <a href="{$home}">{$setup.namesite}</a>
</p>