{capture name=add_seo}
    <h3>Для поисковиков</h3>
    <p><label>Keywords:</label> <br/> <textarea name="keywords" class="form-control"/>{$smarty.post.keywords}</textarea></p>
<p><label>Description:</label> <br/> <textarea name="description" class="form-control"/>{$smarty.post.description}</textarea></p>
{/capture}

{capture name=edit_seo}
    <h3>Для поисковиков</h3>
    <p><label>Keywords:</label> <br/> <textarea name="keywords" class="form-control"/>{$row.keywords|esc}</textarea></p>
<p><label>Description:</label> <br/> <textarea name="description" class="form-control"/>{$row.description|esc}</textarea></p>
{/capture}