&nbsp;</p>
<form action="avatars.php?sid=$sid&do=do_add" method="post">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[avatars] :&nbsp; $lang[adminmenu_addavatar]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[title]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="title" size="32"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[path]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="path" size="32" value="images/avatars"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[display_order]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="displayorder" size="32" value="1"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[category]</td>
          <td class="td1" vAlign="top" width="60%">
          <select name="catid">$catoptions</select></td>
        </tr>
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="   $lang[add]   " size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="$lang[reset]" size="30"></td>
	</tr>
    </table>
    &nbsp;</form>
    
<form action="avatars.php?sid=$sid&do=add_multi" method="post">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[avatars] :&nbsp; $lang[addavatar_multiple]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[path]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="path" size="32" value="images/avatars"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%" dir="ltr">$lang[category]</td>
          <td class="td1" vAlign="top" width="60%" dir="ltr">
          <select name="catid">$catoptions</select></td>
        </tr>
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="   $lang[go]   " size="30"></td>
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