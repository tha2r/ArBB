<form action="lang.php" method="get">
<input name="langid" value="$langid" type="hidden">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="6">
	$lang[adminmenu_langmanage]</td>
    </tr>
	<tr class="td1">
		<td>$lang[phrase_type]</td>
		<td><select name="phrasetype" onchange="window.location='lang.php?langid=$langid&do=lang_phrases&perpage=$perpage&page=$page&phrasetype='+this.value">
        $phrasetypes</select></td>
		<td>Pages</td>
		<td><select name="page" onchange="window.location='lang.php?langid=$langid&do=lang_phrases&phrasetype=$phrasetype&perpage=$perpage&page='+this.value">
        $pages</select></td>
    	<td><input type="submit" value="$lang[go]"></td>
			</tr>
	</table>
</form>
<br>
<form action="style.php?do=do_$do&styleid=$styleid" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="2">$lang[phrase_manager] - ($lang[phrase_type] 
      : $phrasetype)</td>
    </tr>
$phrases
    <tr class="thead">
      <td width="200%" colspan="2">
      <p align="center">
      <input type="button" value="$lang[search_for_phrases]" onclick="window.location='lang.php?do=search&langid=$langid'" name="search">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="button" value="$lang[add_new_phrase]" onclick="window.location='lang.php?do=add&langid=$langid&phrasetype=$phrasetype'" name="addnew"></td>
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