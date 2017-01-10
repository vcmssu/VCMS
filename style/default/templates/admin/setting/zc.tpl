<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/setting">{$title}</a> / Настройки ЗЦ</div>
<div class="fon">
    <form action="{$home}{$panel}/setting/zc" method="post" class="fon">
        <p><label><input type="checkbox" name="watermark" value="1"{if $setup.watermark == 1} checked="check"{/if}/> Наложение копирайта на изображения</label></p>
        <p><label><input type="checkbox" name="autoscreen_video" value="1"{if $setup.autoscreen_video == 1} checked="check"{/if}/> Создание превьюшки к видео. <small>Превью не будет создано, если на сервере нет FFMPEG</small></label></p>
        <p><label><input type="checkbox" name="autoscreen_nth" value="1"{if $setup.autoscreen_nth == 1} checked="check"{/if}/> Создание превью к темам формата NTH</label></p>
        <p><label><input type="checkbox" name="autoscreen_thm" value="1"{if $setup.autoscreen_thm == 1} checked="check"{/if}/> Создание превью к темам формата THM</label></p>
        <p><font color="red">*</font><label>Размер превьюшки при просмотре файла, в пикселях (создаётся с сохранением пропорций):</label> <br/> <input type="text" class="form-control" name="preview" value="{$setup.preview|esc}" required/></p>
        <p><font color="red">*</font><label>Ширина превьюшки в каталоге файлов, в пикселях:</label> <br/> <input type="text" class="form-control" name="previewsmall" value="{$setup.previewsmall|esc}" required/></p>
        <p><font color="red">*</font><label>Высота превьюшки в каталоге файлов, в пикселях:</label> <br/> <input type="text" class="form-control" name="previewsmall2" value="{$setup.previewsmall2|esc}" required/></p>
        <p><font color="red">*</font><label>Время, по истечение которого файлы не будут считать новыми, в секундах:</label> <br/> <input type="text" class="form-control" name="newfile" value="{$setup.newfile|esc}" required/></p>
        <p><input type="submit" name="submit" value="Сохранить" class="btn btn-primary"></p>
    </form> 
</div>