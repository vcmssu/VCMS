<div class="head"><a href="{$home}/profile">Мой кабинет</a> / {$title}</div>
<div class="fon">
    {if $count > 0}
        {foreach from=$arrayrow item=row}
            <div class="list" id="{$row.id}">
                {if $user.id == $row.id_user}
                    <a href="{$home}/id{$row.user_id}">{$row.login2|escape|esc}</a> ({$row.time|times})
                    <span class="pull-right">
                        {if $row.status == 0}
                            заявка ещё не принята
                        {/if}
                        <a href="{$home}/profile/friends/del/{$row.user_id}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                    </span>
                {else}
                    <a href="{$home}/id{$row.id_user}">{$row.login|escape|esc}</a> ({$row.time|times})
                    <span class="pull-right">
                        {if $row.status == 0}
                            <a href="{$home}/profile/friends/yes/{$row.id_user}" title="Принять заявку"><i class="fa fa-plus-square-o"></i></a>
                            {/if}
                        <a href="{$home}/profile/friends/del/{$row.id_user}" title="Удалить"><i class="fa fa-trash-o"></i></a>
                    </span>    
                {/if}
            </div>
        {/foreach}
        {*постраничка*} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if}    
    {else}
        <div class="alert alert-danger">Список друзей пуст...</div>
    {/if}
</div>