<div class="head"><a href="{$home}{$panel}">Административная панель</a> / <a href="{$home}{$panel}/templates">{$title}</a> / {$dirview}</div>
<div class="fon">
    {if $setup.compress != 3}<div class="alert alert-danger">Включёно сжатие HTML. Перед редактированием его рекомендуется <a href="{$home}{$panel}/setting">выключить</a>.</div>{/if}             
    <h3 style="text-align: center;">Главные шаблоны</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона </b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        <tr>
            <td style="text-align:center;">Главная страница</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Шапка сайта</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/system/header.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Футер сайта</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/system/footer.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Сайдбар</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/system/sidebar.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">404</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/error.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Авторизация</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/login.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Регистрация</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/signup.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Восстановление пароля</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/lostpass.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Список пользователей</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/users.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
    </table> 
    <h3 style="text-align: center;">Новости</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона </b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        <tr>
            <td style="text-align:center;">Список новостей</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/news/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Просмотр новости</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/news/view.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Добавление новости</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/news/add.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Все новости</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/news/all.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление новости</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/news/del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование новости</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/news/edit.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование комментария</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/news/edit_comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление комментария</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/news/del_comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
    </table>  
    <h3 style="text-align: center;">Активность пользователя</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона </b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        <tr>
            <td style="text-align:center;">Список постов</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/active/blogs.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Комментарии к постам</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/active/blog_comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Файлы</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/active/download.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Комментарии к файлам</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/active/download_comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Сообщения в гостевой</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/active/guest.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Комментарии к новостям</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/active/news_comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Посты на форуме</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/active/posts.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Темы на форуме</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/active/thems.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
    </table>
    <h3 style="text-align: center;">Личный кабинет пользователя</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона </b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        <tr>
            <td style="text-align:center;">Главная страница</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Черный список</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/blacklist.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Список постов</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/blog.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Добавление поста</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/blog_add.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление поста</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/blog_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование поста</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/blog_edit.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Закладки</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/bookmark.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Добавление закладки</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/bookmark_add.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление закладки</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/bookmark_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование закладки</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/bookmark_edit.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Друзья</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/friends.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Добавление в друзья</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/friends_add.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление друга</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/friends_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Подтверждение заявки на добавление в друзья</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/friends_yes.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Фотогалерея</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/gallery.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Создание альбома</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/gallery_add.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Добавление фото в альбом</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/gallery_add_photo.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление фото</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/gallery_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление альбома</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/gallery_del_album.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование альбома</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/gallery_edit_album.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">История авторизаций</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/hiestory.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Почта</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/mail.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Анкета</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/my.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Уведомления</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/notice.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Смена пароля</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/security.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Настройки</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/profile/setup.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
    </table>
    <h3 style="text-align: center;">Блоги</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона </b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        <tr>
            <td style="text-align:center;">Главная страница</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Категории</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/category.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Добавление категории</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/category_add.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление категории</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/category_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование категории</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/category_edit.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Комментарии</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление поста</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление комментария</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/del_comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование поста</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/edit.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Просмотр поста</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/post.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Поиск</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/search.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Топ постов</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/blogs/top.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
    </table>
    <h3 style="text-align: center;">Загруз центр</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона </b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        <tr>
            <td style="text-align:center;">Главная страница</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Комментарии</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление файла</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление категории</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/del_category.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Удаление комментария</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/del_comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование файла</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/edit.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Редактирование комментария</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/edit_comments.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Доп. файлы</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/file.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Новые файлы</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/new.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Поиск</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/search.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Параметры категории</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/setup.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Топ файлов</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/top.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
        <tr>
            <td style="text-align:center;">Просмотр файла</td> 
            <td style="text-align:center;">   
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/download/view.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a>
        </tr>
    </table>   
    <h3 style="text-align: center;">Форум</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона</b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>	
        <tr>	
            <td style="text-align:center;">Главная страница</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Добавление темы</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/add.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Создание раздела/подраздела</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/add_forum.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Файлы темы</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/files.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Просмотр раздела</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/forum.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Новые посты</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/new_posts.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Новые темы</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/new_thems.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Удаление поста</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/post_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Цитирование поста</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/post_quote.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Ответ на пост</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/post_reply.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Параметры поста</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/post_setup.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Поиск</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/search.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Параметры раздела/подраздела</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/setup.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Удаление раздела/подраздела</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/setup_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Тема</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/tema.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Удаление темы</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/tema_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Параметры темы</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/tema_setup.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Создание голосования</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/vote.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Список проголосовавших</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/vote_all.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Удаление голосования</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/vote_del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Редактирование голосования</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/forum/vote_edit.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
    </table> 
    <h3 style="text-align: center;">Фотогалерея</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона</b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>	
        <tr>	
            <td style="text-align:center;">Главная страница</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/gallery/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Альбомы</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/gallery/albums.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Удаление фотографии</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/gallery/del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Удаление альбома</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/gallery/del_album.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Редактирование альбома</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/gallery/edit_album.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Просмотр фотографии</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/gallery/photo.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Топ фотографий</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/gallery/top.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
    </table>     
    <h3 style="text-align: center;">Гостевая</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона</b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>	
        <tr>	
            <td style="text-align:center;">Главная страница</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/guest/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Удаление сообщения</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/guest/del.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Редактирование сообщения</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/guest/edit.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
    </table> 
    <h3 style="text-align: center;">Онлайн</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона</b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>	
        <tr>	
            <td style="text-align:center;">Пользователи</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/online/index.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Гости</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/online/guest.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
    </table> 
    <h3 style="text-align: center;">Прочие шаблоны</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона</b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>	
        <tr>	
            <td style="text-align:center;">Активация аккаунта</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/activation.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Бан пользователя</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/ban.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">BB коды</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/bbcode.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Смайлы</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/smiles.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <tr>	
            <td style="text-align:center;">Смайлы пользователя</td>
            <td style="text-align:center;">
                <a href="{$home}{$panel}/templates/edit?template={$dirview}/templates/modules/user/smiles_my.tpl" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
        </tr>
    </table>    
    <h3 style="text-align: center;">Стили</h3>
    <table width="100%" border="2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <tr><th style="text-align:center;"><b>Название шаблона</b></th>
            <th style="text-align:center;"><b>Редактор</b></th>
        </tr>
        {foreach from=$arrayrowcss item=css}		
            <tr>	
                <td style="text-align:center;">{$css}</td>
                <td style="text-align:center;">
                    <a href="{$home}{$panel}/templates/edit?template={$dirview}/css/{$css}" title="Редактировать"><i class="fa fa-pencil"></i></a></td>
            </tr>
        {/foreach}
    </table>                   
</div>   