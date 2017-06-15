{foreach from=$entities item=entity key=name}
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
     {foreach from=$entity item=com}
      <tr>
        <td>{$com.type}</td>
        <td>{$com.entity_id}</td>
        <td>{$com.index}</td>
        <td>{$com.description}</td>
        <td>{$com.communication}</td>
     {/foreach}
    </tbody>
  </table>
  <div class="crm-actions-ribbon">
    <ul id="actions">
      <li>
        <a title="{ts}New communication for a {$name}{/ts}" class="search button" href="giroscope/add?mode={$name}">
         <span>
            <div class="icon inform-icon"></div>
            {ts}New communication for a {$name}{/ts}
          </span>
        </a>
      </li>
    </ul>
  </div><br><br>
{/foreach}
