{if $row.type == 1 && empty($user.id)}
    <div class="fon">
        <div class="alert alert-danger margin-top-10">Для того, чтобы просмотреть тему, Вам нужно <a href="{$home}/user/login">авторизоваться</a> или <a href="{$home}/user/signup">зарегистрироваться</a> на сайте!</div>
    </div>    
{else if $row.type == 2 && $user.level < 10}
    <div class="fon">
        <div class="alert alert-danger margin-top-10">Данная тема доступна только администрации сайта!</div>
    </div> 
{else}
    <div class="head"><a href="{$home}/forum">Форум</a> / <a href="{$home}/forum/{$forum.id}">{$forum.name|esc}</a> / <a href="{$home}/forum/{$forum.id}/{$row.id}">{$row.name|esc}</a> / {$title|escape}</div>
    <div class="fon">
        {if $user.level > 30}
            <div class="breadcrumb">
                <a href="{$home}/forum/setup/tema/{$tema.id}">Параметры темы</a> / 
                <a href="{$home}/forum/setup/tema/del/{$tema.id}">Удалить</a> / 
                {if $tema.closed == 0}<a href="{$home}/forum/setup/tema/closed/{$tema.id}">Закрыть</a> / {else}<a href="{$home}/forum/setup/tema/open/{$tema.id}">Открыть</a> / {/if}
                {if $tema.up == 0}<a href="{$home}/forum/setup/tema/up/{$tema.id}">Закрепить</a>{else}<a href="{$home}/forum/setup/tema/down/{$tema.id}">Открепить</a>{/if}
            </div>
        {/if}
        {if $user.level > 30 || $user.id == $tema.id_user}
            {if $tema.countvote == 0}
                <div class="breadcrumb">
                    <a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/vote">Создать голосование</a>            
                </div> 
            {else}
                <div class="breadcrumb">
                    <a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/vote/edit">Редактировать голосование</a> | <a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/vote/del">Удалить голосование</a>           
                </div>        
            {/if}
        {/if}    
        {if isset($error)}<div class="alert alert-danger">{$error}</div>{/if} 
        {if isset($errorvote)}<div class="alert alert-danger">{$errorvote}</div>{/if} 
        {*блок голосования*}
        {if $tema.countvote > 0 && $user.id}
            <div class="fon"><h4><i class="fa fa-question-circle"></i> Голосование </h4>
                <p><b>{$tema.namequestion|esc|escape}</b></p>
                {if $checkvote == 0}
                    <form action="{$smarty.server.REQUEST_URI}" method="post">
                        {foreach from=$arrayrowvote item=vote}
                            <p><label><input type="radio" name="reply" value="{$vote.id}"/> {$vote.name|esc|escape}</label></p>
                                {/foreach}
                        <p><input type="submit" name="vote" value="Выбрать" class="btn btn-primary"></p>    
                    </form>
                {else}
                    {foreach from=$arrayrowvote item=vote}
                        <p>{$vote.name|esc|escape} ({$vote.count|number})</p>
                    {/foreach}
                {/if}
                {if $tema.countvoteall}<div class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/vote/all">Проголосовало: {$tema.countvoteall}</a></div>{/if}            
            </div>
        {/if}
        {if $count > 0}
            {foreach from=$arrayrow item=rows key=k}{*время для изменения своего поста, в секундах*}
                    {math equation="x - y" x=$realtime y={$setup.forum_time_edit_post}*60 assign="edit"}  
                    <div class="list text" id="{$rows.id}">
                        {include file='system/user.tpl'}
                        {$smarty.capture.forum}
                        {$smarty.capture.text}
                        {if $arrayrowfile && $rows.count_file > 0}
                            <h4>Прикрепленные файлы:</h4>
                            {foreach from=$arrayrowfile item=file}
                                {if $rows.id == $file.id_post}
                                    <div class="menu">
                                        {if $file.type == 'png' || $file.type == 'jpg' || $file.type == 'jpeg' || $file.type == 'gif'}
                                            <p><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/load/{$file.id}" title="Скачать файл"><img src="{$home}/files/user/{$file.id_user}/forum/{$file.file}" class="img-responsive img-mini" /></a></p>
                                                {/if}
                                        <a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/load/{$file.id}" title="Скачать файл"><i class="fa fa-file"></i> {$file.file|escape|esc}</a> ({$file.size|esc}{if $file.loadcounts > 0}, скачиваний: {$file.loadcounts|number}{/if})
                                    </div>   
                                {/if}
                            {/foreach}
                        {/if}
                        {if !empty($rows.timeedit)}<div class="list"><small>Изменил <b><a href="{$home}/id{$rows.id_user_edit}">{$rows.login_edit}</a></b> ({$rows.timeedit|times}) [{$rows.kedit}]</small></div>{/if}
                                    {if $user.level > 30 || $user.id == $rows.id_user && $rows.time > $edit && $tema.closed == 0}
                            <span class="breadcrumb"><a href="{$home}/forum/setup/post/{$rows.id}" title="Редактировать"><i class="fa fa-pencil"></i></a>{if $count > 1 && $user.level > 30} <a href="{$home}/forum/setup/post/del/{$rows.id}" title="Удалить"><i class="fa fa-trash-o"></i></a>{/if}</span>
                                {/if}
                    </div>
                {/foreach}
                {else}
                    <div class="alert alert-error">Сообщений ещё нет...</div>
                    {/if}
                        {if $tema.closed == 0}
                            {if $user.id}
                                <form action="{$url}" method="post" enctype="multipart/form-data" class="fon">
                                    <p><font color="red">*</font>Текст сообщения:<br/> 
                                        {include file='system/panel.tpl'}
                                        {$smarty.capture.add_comments}
                                    </p>
                                    {$smarty.capture.add_file}
                                    {if $setup.captcha_add_post == 1}
                                        {include file='system/captcha.tpl'}
                                    {/if}
                                    <p><input type="submit" name="ok" value="Отправить" class="btn btn-primary"></p>
                                </form>
                            {else}
                                <div class="alert alert-danger margin-top-10">Для того, чтобы добавлять сообщения, Вам нужно <a href="{$home}/user/login">авторизоваться</a> или <a href="{$home}/user/signup">зарегистрироваться</a> на сайте!</div>    
                            {/if}
                        {else}
                            <div class="alert alert-danger margin-top-10">Тема закрыта!</div>
                        {/if}
                        {*постраничка*} 
                        {if $count > $message}
                            <div class="paging_bootstrap pagination">{$pagenav}</div>
                        {/if} 
                        {if $tema.count > 0}
                            <div class="menu"><a href="{$home}/forum/{$forum.id}/{$row.id}/{$tema.id}/files"><i class="fa fa-file"></i> Все файлы темы ({$tema.count|number})</a></div> 
                        {/if}
                    </div>
                    {/if}