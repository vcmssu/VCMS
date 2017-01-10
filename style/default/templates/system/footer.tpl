<div class="menu visible-xs visible-sm">На сайте: <a href="{$home}/online">пользователей ({$usersonline|number})</a> / <a href="{$home}/online/guest">гостей ({$guestonline|number})</a></div>
{if $adsfoot} 
    <div class="margin-top-10 list">
        {foreach from=$adsfoot item=foot key=kfoot}
            <p><a href="{$home}/go/{$foot.id}">{$foot.text|escape|esc|bbcode}</a></p>
            {/foreach}
    </div>
{/if}
</div>
</div>
</div>
<footer>  
    <a href="{$home}">{$setup.copy|esc}</a> <span>{$times_page} сек.</span>
    {if $smarty.server.REQUEST_URI != '/' && $user.id}
        <a class="pull-right" href="{$home}/profile/bookmark/add?name={$title}&url={$home}{$smarty.server.REQUEST_URI}"><i class="fa fa-star-half-empty"></i> В закладки</a>
    {/if}
    {$setup.counters}
</footer>
<script src="{$home}/style/{$skin}/js/bootstrap.min.js"></script>
{if $smarty.session.device == 'web'}
    <script src="{$home}/style/{$skin}/js/markitup/jquery.markitup.js"></script>
    <script src="{$home}/style/{$skin}/js/markitup/sets/default/set.js"></script>
    <link rel="stylesheet" href="{$home}/style/{$skin}/js/markitup/skins/markitup/style.css" type="text/css" />
    <link rel="stylesheet" href="{$home}/style/{$skin}/js/markitup/bbcode/style.css" type="text/css" />
{/if}
</body>
</html>