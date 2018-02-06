<br>
      <form action="login.php?action=login" method="post">
        <table  class="table_border" cellpadding="6" cellspacing="1" border="0" align="center" width="50%">
          <tr class="tcat">
            <td align="left" colspan="2"><b>Login</b></td>
          </tr>
          <tr class="td2">
            <td align="left" colspan="2"><b>$options[sitetitle] - $IN_ARBB - $lang[admin_control_panel]</b></td>
          </tr>
          <tr class="td1">
            <td>Username</td>
            <td><input size="35" name="username" value="$user[username]"></td>
          </tr>
          <tr  class="td1">
            <td>Password</td>
            <td><input type="password" size="35" value name="password"></td>
          </tr>
          <tr class="td2">
            <td align="left" colspan="2"><b>$lang[not_logged_no_permission]</b></td>
          </tr>
          <tr class="thead">
            <td align="middle" colSpan="2">
            <input class="input-button" type="submit" value=" - - Login - - "></td>
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