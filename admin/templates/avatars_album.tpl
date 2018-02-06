<br>
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">
<form action="avatars.php?do=savedisporder&catid=$cat[catid]" method="post" name="disporderform">
<tr>
<td width="100%" colspan="2" class="thead">
$lang[current_avatars_in_album] - <if condition="$pagenav">
<select name="page" onchange="window.location.href='avatars.php?do=album&sid=$sid&catid=$cat[catid]&perpage=$perpage&page='+this.value">
$pagenav</select>
</if></td>
</tr>
<tr>
<td width="100%" colspan="2" class="td2">
<table width="100%">
<tr>
$avatarbits
</tr>
</table>
</td></tr>
<tr class="thead" align="center">
<td><input type=submit value=" $lang[save] $lang[display_order] "></td>
</tr>
</form>
</table>
<br><br>
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">
<tr class="tcat" align="center">
<td width="50%"> <a href="avatars.php?sid=$sid&do=add">  [ $lang[adminmenu_addavatar] ]  </a> </td>
<td width="50%"> <a href="avatars.php?sid=$sid&do=edit_album&catid=$cat[catid]">  [ $lang[edit_cat] ]  </a> </td>
</tr>
</table><div align="center">
<br><br>
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>
        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>