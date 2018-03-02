<div class="crm-actions-ribbon">
{foreach from=$entities item=entity}
    <ul id="actions">
      <li>
        <a title="{ts}New communication for a {$entity}{/ts}" class="search button" href="giroscope/add?mode={$entity}">
         <span>
            <div class="icon inform-icon"></div>
            {ts}New communication for a {$entity}{/ts}
          </span>
        </a>
      </li>
    </ul>
{/foreach}
</div>
<br><br>
{foreach from=$communications item=communication key=name}
  <h3>{ts}{$name}{/ts}</h3>
  <table>
    <thead>
      <tr class="columnheader">
        <th>{ts}Type{/ts}</th>
        <th>{ts}{$name}{/ts}</th>
        <th>{ts}Index{/ts}</th>
        <th>{ts}Description{/ts}</th>
        <th>{ts}Communication{/ts}</th>
      </tr>
    </thead>
    <tbody id="iban_results">
     {foreach from=$communication item=com}
      <tr>
        <td>{$com.type}</td>
        <td>{$com.entity_id}</td>
        <td>{$com.index}</td>
        <td>{$com.description}</td>
        <td>{$com.communication}</td>
     {/foreach}
    </tbody>
  </table>
{/foreach}
