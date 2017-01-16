{capture name=add_comments}
    <textarea name="text"{if $smarty.session.device == 'web'} id="bbcode" rows="15"{/if} class="form-control">{$smarty.post.text|escape}</textarea>
    {if $smile && $smarty.session.device == 'web'}
        <div class="fon menu">    
            <div id="emoticons">
                {foreach from=$smile item=onesmile} 
                    <a href="javascript:void(0);" title="{$onesmile.code|esc|escape}"><img src="{$home}/files/smiles/{$onesmile.photo}" /></a>
                    {/foreach}
            </div>
        </div>               
    {/if}
    <div class="menu">
        {if $user.id && $smarty.session.device == 'web'}
            <a href="{$home}/smiles/my">Мои смайлы</a> | 
        {/if}
        <a href="{$home}/smiles">Смайлы</a> | <a href="{$home}/bbcode">BB коды</a>
    </div> 
{/capture}

{capture name=edit_comments}
    <textarea name="text"{if $smarty.session.device == 'web'} id="bbcode" rows="15"{/if} class="form-control">{$row.text|esc|escape}</textarea>
    {if $smile && $smarty.session.device == 'web'}
        <div class="fon menu">    
            <div id="emoticons">
                {foreach from=$smile item=onesmile} 
                    <a href="javascript:void(0);" title="{$onesmile.code|esc|escape}"><img src="{$home}/files/smiles/{$onesmile.photo}" /></a>
                    {/foreach}
            </div>
        </div>               
    {/if}
    <div class="menu">
        {if $user.id && $smarty.session.device == 'web'}
            <a href="{$home}/smiles/my">Мои смайлы</a> | 
        {/if}
        <a href="{$home}/smiles">Смайлы</a> | <a href="{$home}/bbcode">BB коды</a>
    </div> 
{/capture}

{capture name=add_file}
    <p>Прикрепить файлы: <br/> <input type="file" name="file[]" multiple="true" class="form-control"/></p>
    <p>
        Допустимое кол-во файлов: <em>{$setup.filecount_forum}</em><br/>
        Максимальный размер 1 файла: <em>{$setup.filesize_forum}Mb</em>
    </p>
{/capture}

{capture name=smile}
    {if $smile && $smarty.session.device == 'web'}
        <div class="fon menu">    
            <div id="emoticons">
                {foreach from=$smile item=onesmile} 
                    <a href="javascript:void(0);" title="{$onesmile.code|esc|escape}"><img src="{$home}/files/smiles/{$onesmile.photo}" /></a>
                    {/foreach}
            </div>
        </div>               
    {/if}
    <div class="menu">
        {if $user.id && $smarty.session.device == 'web'}
            <a href="{$home}/smiles/my">Мои смайлы</a> | 
        {/if}
        <a href="{$home}/smiles">Смайлы</a> | <a href="{$home}/bbcode">BB коды</a>
    </div> 
{/capture}