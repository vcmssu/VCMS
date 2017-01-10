<p>Здравствуйте, {$row.login}!</p>
<p>Ваш аккаунт забанен за нарушение правил сайта.</p>
{if !empty($banprichina)}Причина бана:<br/><p>{$banprichina|escape|esc}</p>{/if}
<br/><br/><br/>
<p>--<br/>
    С уважением, администрация ресурса <a href="{$home}">{$setup.namesite}</a>
</p>