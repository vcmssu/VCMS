// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2011 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
mySettings = {
    nameSpace: "",
    previewParserPath: '/bbcode/ajax',
    previewAutoRefresh: false,
    markupSet: [
        {name: 'Жирный', key: 'B', openWith: '[b]', closeWith: '[/b]'},
        {name: 'Курсив', key: 'I', openWith: '[i]', closeWith: '[/i]'},
        {name: 'Подчеркнутый', key: 'U', openWith: '[u]', closeWith: '[/u]'},
        {name: 'Зачеркнутый', key: 'S', openWith: '[s]', closeWith: '[/s]'},
        {separator: '---------------'},
        {name: 'Вставить картинку', key: 'P', replaceWith: '[img][![Ссылка на картинку]!][/img]'},
        {name: 'Вставить ссылку', key: 'L', openWith: '[url=[![Ссылка:!:http://]!]]', closeWith: '[/url]', placeHolder: 'Текст ссылки'},
        {separator: '---------------'},
        {name: 'Цвет', openWith: '[color=[![Цвет текста]!]]', closeWith: '[/color]', dropMenu: [
                {name: 'Желтый', openWith: '[color=yellow]', closeWith: '[/color]', className: "col1-1"},
                {name: 'Оранжевый', openWith: '[color=orange]', closeWith: '[/color]', className: "col1-2"},
                {name: 'Красный', openWith: '[color=red]', closeWith: '[/color]', className: "col1-3"},
                {name: 'Синий', openWith: '[color=blue]', closeWith: '[/color]', className: "col2-1"},
                {name: 'Фиолетовый', openWith: '[color=purple]', closeWith: '[/color]', className: "col2-2"},
                {name: 'Зеленый', openWith: '[color=green]', closeWith: '[/color]', className: "col2-3"},
                {name: 'Белый', openWith: '[color=white]', closeWith: '[/color]', className: "col3-1"},
                {name: 'Серый', openWith: '[color=gray]', closeWith: '[/color]', className: "col3-2"},
                {name: 'Черный', openWith: '[color=black]', closeWith: '[/color]', className: "col3-3"}
            ]},
        {name: 'Размер шрифта', key: 'S', openWith: '[size=[![Размер шрифта]!]]', closeWith: '[/size]',
            dropMenu: [
                {name: 'Большой', openWith: '[size=50]', closeWith: '[/size]'},
                {name: 'Нормальный', openWith: '[size=25]', closeWith: '[/size]'},
                {name: 'Маленький', openWith: '[size=10]', closeWith: '[/size]'}
            ]},
        {name: 'По центру', openWith: '[center]', closeWith: '[/center]'},
        /*{name:'Bulleted list', openWith:'[list]\n', closeWith:'\n[/list]'},
         {name:'Numeric list', openWith:'[list=[![Starting number]!]]\n', closeWith:'\n[/list]'}, 
         {name:'List item', openWith:'[*] '},*/
        {separator: '---------------'},
        {name: 'Цитата', openWith: '[quote]', closeWith: '[/quote]'},
        {name: 'Код', openWith: '[code]', closeWith: '[/code]'},
        {name: 'Cписок', openWith: '[*]', closeWith: '[/*]'},
        {name: 'Cпойлер', openWith: '[spoiler=Заголовок спойлера]', closeWith: '[/spoiler]'},
        {separator: '---------------'},
        {name: 'Очистить от BB кодов', className: "clean", replaceWith: function (h) {
                return h.selection.replace(/\[(.*?)\]/g, "")
            }},
        {name: 'Предпросмотр', className: "preview", call: 'preview'}
    ]
}
$(document).ready(function () {
    $('#bbcode, .bbcode').markItUp(mySettings);
    $('#emoticons a').click(function () {
        emoticon = $(this).attr("title");
        $.markItUp({replaceWith: emoticon});
    });
});