<p>
<br>
</p>
<form action="faq.php?do=add&cat=$faqc[faqid]" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="3">$faqc[title]</td>
    </tr>
<tr class="thead">
<td>$faqc[title]</td>
<td align="center"><a href="faq.php?do=edit&faqid=$faqc[faqid]" title="$lang[edit] - $faqc[title]">$lang[edit]</a></td>
<td align="center"><a href="faq.php?do=delete&faqid=$faqc[faqid]" title="$lang[delete] - $faqc[title]">$lang[delete]</a></td></tr>

$faqsc
    <tr class="thead">
      <td width="200%" colspan="3">
      <p align="center">
      <input type="submit" value="$lang[adminmenu_addfaq]" name="addnew"></td>
    </tr>
    </table>
    &nbsp;</form>