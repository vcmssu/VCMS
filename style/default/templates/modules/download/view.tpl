<div class="head"><a href="{$home}/download">Загрузки</a> {foreach from=$pat item=pats name=puts}{$pats}{/foreach} / {$title}</div>
<div class="fon">
    {if $user.level > 40}
        <div class="breadcrumb">
            <a href="{$home}/download/edit/{$row.id}">Редактировать</a> / 
            <a href="{$home}/download/del/{$row.id}">Удалить</a> / 
            <a href="{$home}/download/file/{$row.id}">Дополнительные файлы ({$count|number})</a>
        </div>
    {/if}
    <div class="breadcrumb">
        Добавил: <a href="{$home}/id{$row.id_user}">{$row.login}</a> | Дата: {$row.time|times} | Просмотров: {$row.views|number}
    </div>
    {if $row.type == 'jpg' || $row.type == 'jpeg' || $row.type == 'png' || $row.type == 'gif'}
        <p><a href="{$home}/{$row.path}{$row.file}" title="{$row.name}"><img src="{$home}/{$row.path}view_{$row.file}" alt=""></a></p>
            {/if}
            {if $row.screen}
        <p><a href="{$home}/{$row.path}{$row.screen}"><img src="{$home}/{$row.path}small_{$row.screen}" alt="" /></a></p>
        {else}
            {if $row.type == 'nth' || $row.type == 'thm'}
            <p><img src="{$home}/{$row.path}{$row.file}.GIF" alt="" /></p>
            {/if}
        {/if}
        {if $row.type == 'mp3' || $row.type == 'wav'}
            {*плеер для компов*}
            {if $smarty.session.device == 'web'}
            <p style="text-align:center;">
                <embed src="{$home}/js/mediaplayer.swf" style="width: 100%;" bgcolor="#FFFFFF" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="file={$home}/{$row.path}{$row.file}&autostart=false&provider=sound" height="24">
            </p>
        {else}
            {*для остальных*}
            <p style="text-align:center;">
                <object type="application/x-shockwave-flash" data="{$home}/js/mp3player.swf" width="200" height="20" id="mp3player" name="mp3player">
                    <param name="movie" value="{$home}/js/mp3player.swf" />
                    <param name="flashvars" value="mp3={$home}/{$row.path}{$row.file}" />
                </object>
            </p>
        {/if}
    {/if}
    {if $row.type == 'mp4'}
        {*плеер для компов*}
        {if $smarty.session.device == 'web'}
            <br/>
            <div style="text-align:center;">
                <!--Просмотр выдео-->
                <script type='text/javascript' src='{$home}/js/swfobject-2.2.js'></script>
                <div id='mediaspace{$row.id}'><small>Проигрывание видео не поддерживается вашим браузером.</small></div>
                <script type='text/javascript'>
         var flashInstalled = false;
         		if (typeof(navigator.plugins)!="undefined" && typeof(navigator.plugins["Shockwave Flash"])=="object") { 
         		 flashInstalled = true; 
         		} else if (typeof  window.ActiveXObject !=  "undefined") { 
         			try { 
         				if (new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) { 
         					flashInstalled = true; 
         				} 
         			} catch(e) {}; 
         		};
         		if(!flashInstalled){
         			// NO FLASH
         			document.getElementById("mediaspace{$row.id}").innerHTML="Требуется установить Flash-плеер";
         			
         		}else{
         var flashvars = { file:'{$home}/{$row.path}{$row.file}', image:'{$home}/{$row.path}{$row.file}.GIF', streamer:'start', provider:'http' };
         var params = { allowfullscreen:'true', allowscriptaccess:'always', wmode:'opaque' };
         var attributes = { id:'player', name:'player' };
         swfobject.embedSWF('{$home}/js/player-5.10.swf','mediaspace{$row.id}', '100%','480', '9.0.115', 'false', flashvars, params, attributes);
         }
      </script>
            </div>
        {else}
            {*для остальных*}
        {/if}
    {/if}	
    {if !empty($text)}
        <p>{$text|escape|esc|nl2br}</p>
    {/if}			
    <p>&nbsp;&nbsp;&nbsp;Размер: {$row.size}</p>
    {if $row.type == 'jpg' || $row.type == 'jpeg' || $row.type == 'png' || $row.type == 'gif'}
        <p>&nbsp;&nbsp;&nbsp;Разрешение: {$Img.0} x {$Img.1} пикс.</p>
    {/if}
    <p>&nbsp;&nbsp;&nbsp;Скачиваний: {$row.loadcounts|number}</p>
    {if !empty($row.timeload)}
        <p>&nbsp;&nbsp;&nbsp;Последний раз скачан: {$row.timeload|times}</p>
    {/if}
    <p>&nbsp;&nbsp;&nbsp;Тип файла: {$row.type}</p>
    {*выводим инфу для видео*}
    {if $row.type == 'mp4' || $row.type == '3gp' || $row.type == 'avi' || $row.type == 'wmv'}
        {if $ffmpeg}    
            <p>&nbsp;&nbsp;&nbsp;Разрешение: {$GetFrameWidth} x {$GetFrameHeight} пикс.</p>
            <p>&nbsp;&nbsp;&nbsp;Частота кадров: {$getFrameRate|number} кадров/сек.</p>
            <p>&nbsp;&nbsp;&nbsp;Продолжительность: {$time}</p>
            <p>&nbsp;&nbsp;&nbsp;Кодек: {$getVideoCodec}</p>
            <p>&nbsp;&nbsp;&nbsp;Битрейт: {$getBitRate} KBPS</p>
        {/if}
    {/if}
    {*выводим инфу для аудио*}
    {if $row.type == 'mp3' || $row.type == 'wav' || $row.type == 'amr' || $row.type == 'ogg'}
        {if !empty({$bitrate})}
            <p>&nbsp;&nbsp;&nbsp;Битрейт: {$bitrate} кб/с</p>
        {/if}
        {if !empty({$length})}
            <p>&nbsp;&nbsp;&nbsp;Длительность: {$length}</p>
        {/if}
        {if !empty({$artists})}
            <p>&nbsp;&nbsp;&nbsp;Артист: {$artists|esc}</p>
        {/if}
        {if !empty({$album})}
            <p>&nbsp;&nbsp;&nbsp;Альбом: {$album|esc}</p>
        {/if}
        {if !empty({$year})}
            <p>&nbsp;&nbsp;&nbsp;Год: {$year}</p>
        {/if}
        {if !empty({$genre})}
            <p>&nbsp;&nbsp;&nbsp;Жанр: {$genre|esc}</p>
        {/if}
        {if !empty({$comment})}
            <p>&nbsp;&nbsp;&nbsp;Комментарий: {$comment|esc}</p>
        {/if}
    {/if}
    {*выводим инфу для jar файлов*}
    {if $row.type == 'jar'}
        {if !empty({$versionjar})}
            <p>&nbsp;&nbsp;&nbsp;Версия: {$versionjar}</p>
        {/if}
        {if !empty({$namejar})}
            <p>&nbsp;&nbsp;&nbsp;Название: {$namejar|esc}</p>
        {/if}
        {if !empty({$vendorjar})}
            <p>&nbsp;&nbsp;&nbsp;Производитель: {$vendorjar|esc}</p>
        {/if}
        {if !empty({$profilejar})}
            <p>&nbsp;&nbsp;&nbsp;Профиль: {$profilejar|esc}</p>
        {/if}
    {/if} 
    <div style="text-align:center;">
        <b>Поделиться файлом</b><br/>
        <div class="share42init"></div>
        <script type="text/javascript" src="{$home}/js/share42/share42.js"></script>	
        <p class="margin-top-10 menu"><a href="{$home}/download/load/{$row.id}">Скачать файл</a></p>
        <p class="menu"><a href="{$home}/download/comments/{$row.id}">Комментарии ({$row.count|number})</a></p>
        <p><input type="text" value="{$home}/{$row.path}{$row.file}" class="form-control"></p>
            {if $row.type == 'jpg' || $row.type == 'jpeg' || $row.type == 'png' || $row.type == 'gif'}
            <form action="{$home}/download/load/{$row.id}" method="post" class="links">
                <p>
                    Выберите разрешение: <br/>
                    <select name="pic" class="form-control">
                        <option value="240x320">240x320</option>
                        <option value="360x640">360x640</option>
                        <option value="480x800">480x800</option>
                        <option value="480x854">480x854</option>
                        <option value="540x960">540x960</option>
                    </select>
                </p>
                <p><label><input type="checkbox" name="pr" value="1"/> Сохранять пропорции</label></p>
                <p><input type="submit" name="ok" value="Скачать файл" class="btn btn-primary"></p>
            </form>
        {/if}
    </div>
    {if $count > 0}
        <div class="alert alert-info" id="files">Дополнительные файлы:</div>
        {foreach from=$arrayrow item=file}
            <div class="list" id="{$file.id}">
                <a href="{$home}/download/{$file.id}-{$file.translate}" title="Перейти к файлу">{$file.name|esc}</a>
                <span class="pull-right">{$file.size}, просмотров: {$file.views|number}, скачиваний: {$file.loadcounts|number}</span>
                <p><a href="{$home}/download/load/{$file.id}">Скачать файл</a></p>
            </div>
        {/foreach} 
        {if $count > $message}
            <div class="paging_bootstrap pagination">{$pagenav}</div>
        {/if}    
    {/if}
</div>
{if $row.id_file > 0}
    <div class="menu"><a href="{$home}/download/{$row.id_file}-{$onefile.translate}"><i class="fa fa-angle-left"></i> К основному файлу</a></div>
{/if}