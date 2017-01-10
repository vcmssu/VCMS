<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/sitemap">{$title}</a> / Настройка генерации</div>
<div class="fon">
    <form action="{$home}{$panel}/sitemap/setup" method="post" class="fon">
        <p><font color="red">*</font><label>Генерация индексного файла:</label><br/>
            <label><input type="radio" name="sitemap_index" value="1"{if $setup.sitemap_index == 1} checked="check"{/if}> включена</label><br/>
            <label><input type="radio" name="sitemap_index" value="2"{if $setup.sitemap_index == 2} checked="check"{/if}> отключена</label><br/>
        </p>
        <p>
        <font color="red">*</font><label>Генерация текстовой карты сайта:</label><br/>
        <label><input type="radio" name="sitemap_txt" value="1"{if $setup.sitemap_txt == 1} checked="check"{/if}> включена</label><br/>
        <label><input type="radio" name="sitemap_txt" value="2"{if $setup.sitemap_txt == 2} checked="check"{/if}> отключена</label><br/>
        </p>
        <p>
        <font color="red">*</font><label>Вероятная частота изменения:</label> <select class="form-control" name="sitemap_changefreq">
            <option value="always" {if $setup.sitemap_changefreq == 'always'}selected="selected"{/if}>всегда</option>
            <option value="hourly" {if $setup.sitemap_changefreq == 'hourly'}selected="selected"{/if}>каждый час</option>
            <option value="daily" {if $setup.sitemap_changefreq == 'daily'}selected="selected"{/if}>ежедневно</option>
            <option value="weekly" {if $setup.sitemap_changefreq == 'weekly'}selected="selected"{/if}>еженедельно</option>
            <option value="monthly" {if $setup.sitemap_changefreq == 'monthly'}selected="selected"{/if}>ежемесячно</option>
            <option value="yearly" {if $setup.sitemap_changefreq == 'yearly'}selected="selected"{/if}>ежегодно</option>
            <option value="never" {if $setup.sitemap_changefreq == 'never'}selected="selected"{/if}>никогда</option>
        </select>
        </p>
        <p>
        <font color="red">*</font><label>Приоритет, допустимый диапазон значений — от 0,0 до 1,0:</label> <br/> 
        <input type="text" class="form-control" name="sitemap_priority" value="{$setup.sitemap_priority|esc}" required/>
        </p>
        <input type="submit" name="submit" value="Сохранить настройки" class="btn btn-primary">
    </form>
    <h3>Определения XML-тегов</h3>
    <table width="80%" class="table table-bordered table-striped table-condensed">
        <tbody>
            <tr>
                <th>
                    Атрибут
                </th>
                <th>
                </th>
                <th>
                    Описание
                </th>
            </tr>
            <tr>
                <td>
                    <a name="urlsetdef" id="urlsetdef"></a><code>&lt;urlset&gt;</code>
                </td>
                <td>
                    обязательный
                </td>
                <td>
                    <p>
                        Инкапсулирует этот файл и указывает стандарт текущего протокола.
                    </p>
                </td>
            </tr>
            <tr class="alt">
                <td>
                    <a name="urldef" id="urldef"></a><code>&lt;url&gt;</code>
                </td>
                <td>
                    обязательный
                </td>
                <td>
                    <p>
                        Родительский тег для каждой записи URL-адреса. Остальные теги являются дочерними
                        для этого тега.
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <a name="locdef" id="locdef"></a><code>&lt;loc&gt;</code>
                </td>
                <td>
                    обязательный
                </td>
                <td>
                    <p>
                        URL-адрес страницы. Этот URL-адрес должен начинаться с префикса (например, HTTP)
                        и заканчиваться косой чертой, если Ваш веб-сервер требует этого. Длина этого значения
                        не должна превышать 2048 символов.
                    </p>
                </td>
            </tr>
            <tr class="alt">
                <td>
                    <a name="lastmoddef" id="lastmoddef"></a><code>&lt;lastmod&gt;</code>
                </td>
                <td>
                    необязательно
                </td>
                <td>
                    <p>
                        Дата последнего изменения файла. Эта дата должна быть в формате <a href="http://www.w3.org/TR/NOTE-datetime">
                            W3C Datetime</a>. Этот формат позволяет при необходимости опустить сегмент времени
                        и использовать формат ГГГГ-ММ-ДД.
                    </p>
                    <p>
                        Обратите внимание, что этот тег не имеет отношения к заголовку "If-Modified-Since
                        (304)", который может вернуть сервер, поэтому поисковые системы могут по-разному
                        использовать информацию из этих двух источников.
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <a name="changefreqdef" id="changefreqdef"></a><code>&lt;changefreq&gt;</code>
                </td>
                <td>
                    необязательно
                </td>
                <td>
                    <p>
                        Вероятная частота изменения этой страницы. Это значение предоставляет общую информацию
                        для поисковых систем и может не соответствовать точно частоте сканирования этой
                        страницы. Допустимые значения:
                    </p>
                    <ul>
                        <li>always</li>
                        <li>hourly</li>
                        <li>daily</li>
                        <li>weekly</li>
                        <li>monthly</li>
                        <li>yearly</li>
                        <li>never</li>
                    </ul>
                    <p>
                        Значение"всегда" должно использоваться для описания документов, которые изменяются
                        при каждом доступе к этим документам. Значение "никогда" должно использоваться для
                        описания архивных URL-адресов.
                    </p>
                    <p>
                        Имейте в виду, что значение для этого тега рассматривается как <i>подсказка</i>,
                        а не как команда. Несмотря на то, что сканеры поисковой системы учитывают эту информацию
                        при принятии решений, они могут сканировать страницы с пометкой "ежечасно" менее
                        часто, чем указано, а страницы с пометкой "ежегодно" – более часто, чем указано.
                        Сканеры могут периодически сканировать страницы с пометкой "никогда", чтобы отслеживать
                        неожиданные изменения на этих страницах.
                    </p>
                </td>
            </tr>
            <tr class="alt">
                <td>
                    <a name="prioritydef" id="prioritydef"></a><code>&lt;priority&gt;</code>
                </td>
                <td>
                    необязательно
                </td>
                <td>
                    <p>
                        Приоритетность URL относительно других URL на Вашем сайте. Допустимый диапазон значений
                        — от 0,0 до 1,0. Это значение не влияет на процедуру сравнения Ваших страниц со
                        страницами на других сайтах — оно только позволяет указать поисковым системам, какие
                        страницы, по Вашему мнению, более важны для сканеров.
                    </p>
                    <p>
                        Приоритет страницы по умолчанию — 0,5.
                    </p>
                    <p>
                        Следует учитывать, что приоритет, который Вы назначили странице, не влияет на положение
                        Ваших URL на страницах результатов той или иной поисковой системы. Поисковые системы
                        используют эту информацию при обработке URL, которые относятся к одному и тому же
                        сайту, поэтому можно использовать этот тег для увеличения вероятности присутствия
                        в поисковом индексе Ваших самых важных страниц.
                    </p>
                    <p>
                        Кроме того, следует учитывать, что назначение высокого приоритета всем URL на Вашем
                        сайте не имеет смысла. Поскольку приоритетность – величина относительная, этот параметр
                        используется для того, чтобы определить очередность обработки URL в пределах сайта.
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>