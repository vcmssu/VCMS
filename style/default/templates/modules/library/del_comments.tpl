<div class="head"><a href="{$home}/library">Библиотека</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / <a href="{$home}/library/{$row.id_file}-{$row.translate}">{$row.name|esc}</a> / {$title}</div>
<div class="fon">
    {include file='system/error.tpl'}
    {$smarty.capture.del_comments}
</div>
<div class="menu"><a href="{$home}/library/comments/{$row.refid}"><i class="fa fa-angle-left"></i> Вернуться к комментариям</a></div> 