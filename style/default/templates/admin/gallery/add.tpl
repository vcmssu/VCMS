<section id="main-content"{if $smarty.cookies.filteradmin == 1} class="merge-left"{/if}>
    <section class="wrapper site-min-height">
        <section class="panel"><header class="panel-heading"><a href="{$home}{$panel}">Главная</a> / <a href="{$home}{$panel}/gallery">{$title}</a> / Добавить альбом</header>
            {if isset($error)}<div class="alert alert-danger">
                    <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>{$error}</div>{/if}    
                <form action="{$home}{$panel}/gallery/add" method="post" enctype="multipart/form-data">
                    <font color="red">*</font><label>Выберите товар:</label> <br/> 
                    <select name="id_products" class="form-control" required>
                        {foreach from=$arrayrow item=rows}
                            <option value="{$rows.id}">{$rows.name|esc}</option>
                        {/foreach}
                    </select>
                    <br/><br/>
                    <font color="red">*</font><label>Название:</label> <br/> <input type="text" class="form-control" name="name" value="{$smarty.post.name}" required/><br/><br/>
                    <font color="red">*</font><label>Фотографии:</label> <br/> <input type="file" class="form-control" name="photo[]" multiple="true" accept="image/*" required/><br/><br/>
                    <br/><input type="submit" name="ok" value="Отправить" class="btn">
                </form>
            </section>    
        </section>
    </section> 