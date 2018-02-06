<p><br></p>
	
<form action="style.php?do=download&sid=$sid" method="post">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[download]</td>
    </tr>
	<tr class="td1">
		<td>$lang[style_title]</td>
		<td><select name="styleid">$styleselect</select></td>
			</tr>
	<tr class="td1">
		<td>$lang[filename]</td>
		<td>
        <input type="text" size="40" name="filename" value="arbb-style.xml"></td>
			</tr>
	<tr class="thead" align="center">
		<td width="50%">
      <input type="submit" value="$lang[download]"></td>
		<td width="50%">
      <input type="reset" value="$lang[reset]"></td>
			</tr>
	</table>
</form>
<br>
<form action="style.php?do=upload" enctype="multipart/form-data" method="post">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[upload]</td>
    </tr>
	<tr class="td1">
		<td>$lang[browse_for_file]</td>
		<td><input type="file" name="file" size="20"></td>
			</tr>
	<tr class="td1">
		<td>$lang[or_enter_file_dir]</td>
		<td>
        <input type="text" size="40" name="filedir"></td>
			</tr>
	<tr class="td1">
		<td>$lang[title_for_uploaded_file]</td>
		<td>
        <input type="text" size="40" name="styletitle"></td>
			</tr>
	<tr class="thead" align="center">
		<td width="50%">
      <input type="submit" value="$lang[upload]"></td>
		<td width="50%">
      <input type="reset" value="$lang[reset]"></td>
			</tr>
	</table>
</form>
<div align="center">
<br><br>
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>
        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>