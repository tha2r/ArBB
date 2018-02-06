<br><Br>

<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
<form action="bbcodes.php" method="get">
<input type="hidden" name="sid" value="$sid">
<input type="hidden" name="do" value="add">
 <tr>
    <td width="100%" colspan="6" class="tcat">$lang[adminmenu_bbcodemanage]</td>
  </tr>
  <tr align="center" class="thead">
    <td width="30%">$lang[bbcode_tag]</td>
    <td width="45%">$lang[explanation]</td>
    <td width="5%">$lang[bbcode_parms]</td>
    <td width="10%">$lang[edit]</td>
    <td width="10%">$lang[delete]</td>
  </tr>
$bbcodes
    <form action="users.php?sid=$sid&do=do_search&page=$nextpage" method="post">
    $hiddeninputs
  <tr>
    <td align="center" colspan="6" class="tcat"><input type="submit" value="$lang[adminmenu_addbbcode]"></td>
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