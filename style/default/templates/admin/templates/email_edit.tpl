<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/templates">{$title}</a> / <a href="{$home}{$panel}/templates/email">Шаблоны писем</a> / {$email}</div>
<div class="fon">
    <form action="{$smarty.server.REQUEST_URI}" method="post" class="fon">
        <textarea name="text" id="code" rows="25" class="form-control"/>{$template|escape}</textarea><br/>
        <input type="submit" name="ok" value="Сохранить шаблон" class="btn btn-primary">
    </form>
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
        <script>
            {literal}
                var mixedMode = {
                    name: "htmlmixed",
                    scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                            mode: null},
                        {matches: /(text|application)\/(x-)?vb(a|script)/i,
                            mode: "text/x-scss"}]
                };
                var editor1 = CodeMirror.fromTextArea(document.getElementById("code"), {mode: mixedMode, tabMode: "indent"});
            {/literal}  

        </script>{/if}         
    </div>