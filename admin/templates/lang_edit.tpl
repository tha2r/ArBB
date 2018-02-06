<form action="lang.php?do=do_lang_edit&langid=$langid" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" colspan="2" aliogn="center">$lang[language_settings] : $lng[languageid] (<b>$lng[title]</b>)</td>
    </tr>
    <tr class="td1">
      <td width="50%">$lang[language_title]</td>
      <td width="50%">
      <input type="text" name="lang[title]" value="$lng[title]" size="30"></td>
    </tr>
    <tr class="td1">
      <td width="50%">$lang[allow_users_to_use]</td>
      <td width="50%">
        <input type="radio" $CHECKED[1] value="1" name="lang[userselect]">$lang[yes]
        <input type="radio" $CHECKED[0] value="0" name="lang[userselect]">$lang[no]
      </td>
    </tr>
    <tr class="td1">
      <td width="50%">$lang[text_direction]</td>
      <td width="50%">&nbsp;
      <input type="radio" $CHECKED[ltr] value="ltr" name="lang[textdirection]">$lang[ltr]
        <br>
     &nbsp; <input type="radio" $CHECKED[rtl] value="rtl" name="lang[textdirection]">$lang[rtl] 
      </td>
    </tr>
    <tr class="td1">
      <td width="50%">$lang[charset]</td>
      <td width="50%">
      <input type="text" name="lang[charset]" value="$lng[charset]" size="30"></td>
    </tr>
      <tr class="thead">
      <td width="50%" align="center">
      <input type="submit" name="update" value="$lang[update]" size="30"></td>
      <td width="50%" align="center">
      <input type="button" name="back" value="$lang[back]" size="30" onclick="window.location='javascript:history.back();'"></td>
      <noscript><a href="lang.php?SID=$SID">$lang[back]</a></noscript></td>
      </tr>
  </table>
</form>