<p>Здравствуйте, {$row.login}!</p>
<p>Вы начали процедуру по восстановлению пароля на сайте {$home}</p>
<p>Для того чтобы восстановить пароль, вам необходимо перейти по ссылке: {$home}/user/reset/{$row.id}/{$realtime|md5}</p>
<p>Ссылка действительна в течение 1 часа!</p>
<p>Если это письмо попало к вам по ошибке или вы не собираетесь восстанавливать пароль, то просто проигнорируйте его.</p>
<br/><br/><br/>
<p>--<br/>
    С уважением, администрация ресурса <a href="{$home}">{$setup.namesite}</a>
</p>