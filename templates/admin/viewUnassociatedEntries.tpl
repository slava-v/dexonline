{extends "layout-admin.tpl"}

{block "title"}Intrări neasociate{/block}

{block "content"}

  <h3>{$entries|count} intrări neasociate cu definiții / lexeme</h3>

  {foreach $entries as $e name=entryLoop}
    {include "bits/entry.tpl" entry=$e editLink=true}
    {if !$smarty.foreach.entryLoop.last} | {/if}
  {/foreach}

{/block}
