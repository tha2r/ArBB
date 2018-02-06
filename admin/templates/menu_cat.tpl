<br>
<table class="table_border" ondblclick="expandcollapse('menu_$cat[mid]'); return false;" cellpadding="3" cellspacing="1" border="0" width="95%" align="center">
<tbody>
<tr>
<td class="thead" align="center"><div style="float:right">
<a href="index.php?action=menu&mid=$cat[mid]" target="_self" onclick="expandcollapse('menu_$cat[mid]');return false;"><img src="../cpstyles/default/cp_$src.gif" title="$langexpcoll" id="button_menu_$cat[mid]" alt="" border="0"></a>
</div>$cat[name]</td>
</tr>
</tbody>
<tbody id="table_menu_$cat[mid]" style="display:$nonedisp">
$catcontents
</tbody>
</table>