<br><Br>

<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">

 <tr>
    <td width="100%" colspan="6" class="tcat">$lang[search_results]</td>
  </tr>
  <tr align="center" class="thead">
    <td width="20%">$lang[username]</td>
    <td width="20%">$lang[email]</td>
    <td width="15%">$lang[join_date]</td>
    <td width="1%">$lang[posts]</td>
    <td width="15%">$lang[last_activity]</td>
    <td width="30%">$lang[options]</td>
  </tr>
$usersbits
    <form action="users.php?sid=$sid&do=do_search&page=$nextpage" method="post">
    $hiddeninputs
  <tr>
    <td align="center" colspan="6" class="tcat">&nbsp;$pagenav </td>
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