<div class="head"><a href="{$home}{$panel}">Административная панель</a> / {$title}</div>
<div class="fon">
    <div class="head">{$title}</div>
    <div class="list"><i class="fa fa-star"></i> Версия VCMS: {$setup.version}</div>
    <div class="list"><i class="fa fa-star"></i> Версия PHP: {$php} {if $php > '5.4'}<font color="green">OK</font>{else}<font color="red">Версия PHP устаревшая и не поддерживается системой{/if}</div>
    <div class="list"><i class="fa fa-star"></i> MySQL: {if $mysql == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение MySQL не загружено!{/if}</div>
    <div class="list"><i class="fa fa-star"></i> PDO: {if $pdo == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение PDO не загружено!{/if}</div>
    <div class="list"><i class="fa fa-star"></i> GD: {if $gd == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение GD не загружено!{/if}</div>
    <div class="list"><i class="fa fa-star"></i> ZLIB: {if $zlib == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение ZLIB не загружено!{/if}</div>
    <div class="list"><i class="fa fa-star"></i> ICONV: {if $iconv == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение ICONV не загружено!{/if}</div>
    <div class="list"><i class="fa fa-star"></i> Mbstring: {if $mbstring == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение mbstring не загружено!{/if}</div>
    <div class="list"><i class="fa fa-star"></i> XML: {if $xml == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение XML не загружено!{/if}</div>
    <div class="list"><i class="fa fa-star"></i> XMLWriter: {if $XMLWriter == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение XMLWriter не загружено!{/if}</div>
    <div class="list"><i class="fa fa-star"></i> FFMPEG: {if $ffmpeg == 1}<font color="green">OK</font>{else}<font color="red">Ошибка! Расширение FFMPEG не загружено!{/if}</div>
</div>