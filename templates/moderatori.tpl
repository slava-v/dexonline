{extends "layout-admin.tpl"}

{block "title"}Moderatori{/block}

{block "content"}
  <h3>Moderatori</h3>

  <form method="post" action="moderatori">
    <table class="table table-condensed table-striped table-bordered">

      <tr>
        <th>nume utilizator</th>
        <th>privilegii</th>
      </tr>

      {foreach $users as $user}
        <tr>
          <td class="userNick">
            <a href="{$wwwRoot}utilizator/{$user->nick}">{$user->nick}</a>
            <input type="hidden" name="userIds[]" value="{$user->id}"/>
          </td>

          <td>
            <select name="priv_{$user->id}[]" class="form-control" multiple>
              {section name="bit" loop=$smarty.const.NUM_PRIVILEGES}
                {$i=$smarty.section.bit.index}
                {math equation="1 << x" x=$i assign="mask"}
                <option value="{$mask}" {if $user->moderator & $mask}selected{/if}>
                  {$GLOBALS['PRIV_NAMES'][$i]}
                </option>
              {/section}
            </select>
          </td>
        </tr>
      {/foreach}

      <tr>
        <td>
	        <input type="text" name="newNick" class="form-control" placeholder="moderator nou">
        </td>
        <td>
          <select name="newPriv[]" class="form-control" multiple>
            {section name="bit" loop=$smarty.const.NUM_PRIVILEGES}
              {$i=$smarty.section.bit.index}
              {math equation="1 << x" x=$i assign="mask"}
              {math equation="1 << x" x=$smarty.section.bit.index assign="mask"}
              <option value="{$mask}">
                {$GLOBALS['PRIV_NAMES'][$i]}
              </option>
            {/section}
          </select>
        </td>
      </tr>

    </table>

    <button type="submit" class="btn btn-success" name="saveButton">
      <i class="glyphicon glyphicon-floppy-disk"></i>
      <u>s</u>alvează
    </button>

  </form>
{/block}
