<div class="crm-actions-ribbon">
{ts}Create new communication for : {/ts}
{foreach from=$entities item=entity}
    <ul id="actions">
      <li>
        <a title="{ts}{$entity}{/ts}" class="search button" href="add?mode={$entity}">
         <span>
            <div class="icon inform-icon"></div>
            {ts}{$entity}{/ts}
          </span>
        </a>
      </li>
    </ul>
{/foreach}
</div>
<br><br>
<table>
  {foreach from=$communications item=communication key=name}
  <thead>
    <tr>
      <td colspan="4"><h3>{ts}{$name}{/ts}</h3></td>
    </tr>
    <tr class="columnheader">
      <th width="20%">{ts}Communication{/ts}</th>
      <th width="30%">{ts}Description{/ts}</th>
      <th width="20%">{ts}Type{/ts}</th>
      <th width="30%">{ts}{$name}{/ts}</th>
    </tr>
  </thead>
  <tbody id="iban_results"> 
     {foreach from=$communication item=com}
      <tr>
        <td><b>{$com.communication}</b></td>
      {if $com.description eq ''}
        <td>-</td>
      {else}
        <td>{$com.description}</td>
      {/if}
        <td>{$com.type}</td>
        <td>{$com.entity_name}</td>
     </tr>
     {/foreach}
    </tbody>
  {/foreach}
</table>
