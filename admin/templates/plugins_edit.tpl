<form action="plugins.php" method="post">
<input name="do" value="do_edit" type="hidden">
<input type="hidden" name="pid" value="$plugin[pid]">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
        <tr class="tcat">
        <td colspan="2">
        $lang[edit] -
        $plugin[title]</td>
    </tr>
        <tr class="td1">
                <td>$lang[location]</td>
                <td>$placeoptions</td>
    </tr>
    <tr class="td1">
                <td>$lang[title]</td>
                <td>
        <input type="text" size="35" name="title" value="$plugin[title]"></td>
    </tr>
    <tr class="td1">
                <td>$lang[plugins_code]</td>
                <td><textarea rows="5" cols="40" name="phpcode">$plugin[phpcode]</textarea></td>
    </tr>
    <tr class="td1">
                <td>$lang[plugins_active]</td>
                <td><input type="radio" name="active" value="1" $checkedyes> $lang[yes]&nbsp;&nbsp; <input type="radio" name="active" value="0" $checkedno>$lang[no]</td>
    </tr>
        <tr class="thead">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[edit]" size="30"></td>
      <td width="50%" align="center">
      <input type="button" name="back" value="$lang[back]" size="30" onclick="window.location='javascript:history.back();'"></td>
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