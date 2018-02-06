    
<form action="avatars.php?sid=$sid&do=do_editav" method="post">
<input type=hidden name="avid" value="$av[avid]">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[avatars] :&nbsp; $lang[edit] 
          $av[title]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" colspan="2" align="center"><img src="../$av[path]" border='0'></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[title]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="title" size="32" value="$av[title]"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%" dir="ltr">$lang[category]</td>
          <td class="td1" vAlign="top" width="60%" dir="ltr">
          <select name="catid">$catoptions</select></td>
        </tr>
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="edit" value="   $lang[edit]   " size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="$lang[reset]" size="30"></td>
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