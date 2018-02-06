<br>
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">
<form action="smilies.php?sid=$sid&do=add" method="post">
<tr>
<td width="100%" colspan="2" class="thead">
<if condition="$pagenav"><div style="float:right;"><select name="page" onchange="window.location.href='smilies.php?sid=$sid&perpage=$perpage&page='+this.value">$pagenav</select></div></if>
$lang[adminmenu_smilies]
</td>
</tr>
<tr>
<td width="100%" colspan="2" class="td2">
<table width="100%">
<tr>
$smilies
</tr>
</table>
</td></tr>
<tr class="thead" align="center">
<td><input type=submit value=" $lang[adminmenu_addsmilies] "></td>
</tr>
</form>
</table>
<div align="center">
<br><br>
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>
        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>