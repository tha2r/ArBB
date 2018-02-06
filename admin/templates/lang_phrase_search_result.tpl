<form action="lang.php" method="get">
<input name="langid" value="$langid" type="hidden">
</form>
<p>
<br>
</p>
<form action="style.php?do=do_$do&styleid=$styleid" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" align="center" colspan="3">$lang[phrase_manager] - (results : 
      $num)</td>
    </tr>
$phrases
    <tr class="thead">
      <td width="200%" colspan="3">
      &nbsp;</td>
    </tr>
    </table>
    &nbsp;</form>
<div align="center">
<br><br>
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>
        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>