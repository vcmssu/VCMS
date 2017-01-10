{capture name=comments}
    <div class="alert alert-danger margin-top-10">Для того, чтобы оставить комментарий, Вам нужно <a href="{$home}/user/login">авторизоваться</a> или <a href="{$home}/user/signup">зарегистрироваться</a> на сайте!</div> 
{/capture}

{capture name=del_comments}
    <p>{$text|escape|esc|nl2br}</p>
    <form action="{$url}" method="post" class="fon">
        <div class="alert alert-danger">Вы уверены, что хотите удалить данный комментарий?</div>
        <input type="submit" name="ok" value="Да" class="btn btn-primary"> <input type="submit" name="close" value="Отменить" class="btn btn-primary">
    </form>
{/capture}