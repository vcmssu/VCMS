<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/templates">{$title}</a> / <a href="{$home}{$panel}/templates/view/{$skin.0}">{$skin.0}</a> / ../style/{$dirview}</div>
<div class="fon">
    {if isset($error)}<div class="alert alert-danger">{$error}</div>
            {else}
                {if $setup.highlight == 1}                
            <link rel="stylesheet" href="{$home}/js/codemirror/lib/codemirror.css">
            <script src="{$home}/js/codemirror/lib/codemirror.js"></script>
            <script src="{$home}/js/codemirror/mode/xml/xml.js"></script>
            <script src="{$home}/js/codemirror/mode/javascript/javascript.js"></script>
            <script src="{$home}/js/codemirror/mode/css/css.js"></script>
            <script src="{$home}/js/codemirror/mode/vbscript/vbscript.js"></script>
            <script src="{$home}/js/codemirror/mode/htmlmixed/htmlmixed.js"></script>	
            <style type="text/css">
                {literal}
                    .CodeMirror {border-top: 1px solid #888; border-bottom: 1px solid #888; border: 1px solid #888;}
                {/literal}
            </style>	
        {/if}
        <form action="{$home}" method="post" class="fon">
            <textarea name="text" id="code" class="form-control" rows="25"/>{$template|escape}</textarea><br/>
            <input type="submit" name="ok" value="Сохранить шаблон" class="btn btn-primary"> {*<input type="submit" name="create" value="Создать резервную копию" class="btn btn-primary"> {if $backup}<input type="submit" name="reload" value="Восстановить из резервной копии" class="btn btn-primary">{/if}*}<br/><br/>
        </form>
        <div class="alert alert-danger">Внимание: редактирование переменных, заключенных в круглые кавычки <b>{}</b>, приведет к неработосбособности сайта!</div>                
        {if $setup.highlight == 1} {if $css_style < 3}
                <script>
                    {literal}
                        var mixedMode = {
                            name: "htmlmixed",
                            scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                                    mode: null},
                                {matches: /(text|application)\/(x-)?vb(a|script)/i,
                                    mode: "text/x-scss"}]
                        };
                        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {mode: mixedMode, tabMode: "indent"});
                    {/literal}  
                </script>	
            {/if}
            {if $css_style == 3}
                <script>
                    {literal}
                        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                            lineNumbers: true,
                            matchBrackets: true,
                            mode: "text/x-scss"
                        });
                    {/literal}  
                </script>  
        {/if}{/if}  
    {if $setup.compress != 3}<div class="alert alert-danger">Включёно сжатие HTML. Перед редактированием его рекомендуется <a href="{$home}{$panel}/setting">выключить</a>.</div>{/if}                 
{/if}  
</div>   