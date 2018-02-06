&nbsp;</p>
<form action="smilies.php?sid=$sid&do=do_edit&smid=$sm[sid]" method="post">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[edit] : $sm[title]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[image]</td>
          <td class="td1" vAlign="top" width="60%"><img src="../$sm[path]"></td>
        </tr>
         <tr>
          <td class="td1" vAlign="top" width="40%">$lang[title]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="title" size="32" value="$sm[title]"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[replacement_text]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="text" size="32" value="$sm[text]"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[path]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" ReadOnly  name="path" size="32" value="$sm[path]"></td>
        </tr>
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="   $lang[edit]   " size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="$lang[reset]" size="30"></td>
	</tr>
    </table> &nbsp;
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