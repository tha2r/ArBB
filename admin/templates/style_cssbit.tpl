 <table class="table_border" cellSpacing="0" cellPadding="1" width="95%" align="center" border="0">
    <tr>
      <td>
      <table cellSpacing="0" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$tmp[title]</td>
        </tr>
        <tr>
          <td class="thead" align="middle" dir="ltr">$lang[main_css_attributes]</td>
          <td class="thead" align="middle" dir="ltr">$lang[extra_css_attributes]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="50%">
          <table width="100%" class="td1" border="0">
            <tr>
              <td>$lang[background]</td>
              <td>
              <input size="25" value="$css[background]" name="css[$tmp[title]][background]"></td>
            </tr>
            <tr>
              <td>$lang[font_color]</td>
              <td>
              <input size="25" value="$css[color]" name="css[$tmp[title]][color]"></td>
            </tr>
            <tr>
              <td>$lang[font_family]</td>
              <td>
              <input size="25" name="css[$tmp[title]][font_family]" value="$css[font_family]"></td>
            </tr>
            <tr>
              <td>$lang[font_size]</td>
              <td>
              <input size="25" name="css[$tmp[title]][font_size]" value="$css[font_size]"></td>
            </tr>
            <tr>
              <td>Font Style</td>
              <td>
              <input size="25" name="css[$tmp[title]][font_style]" value="$css[font_style]"></td>
            </tr>
            <tr>
              <td>Font Weight</td>
              <td>
              <input size="25" name="css[$tmp[title]][font_weight]" value="$css[font_weight]"></td>
            </tr>
          </table>
          </td>
          <td class="td1" width="50%" top>
          <textarea style="PADDING-RIGHT: 4px; PADDING-LEFT: 4px; PADDING-BOTTOM: 4px; WIDTH: 98%; PADDING-TOP: 4px" name="css[$tmp[title]][extra]" rows="9" cols="20">$css[extra]</textarea> </td>
        </tr>
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[link_css_attributes]</td>
        </tr>
        <tr>
          <td class="td2" colSpan="2">
          <table width="100%"  class="tdf" border="0">
            <tr>
              <td><fieldset>
              <legend>Normal Links</legend>
              <table  class="tdf"  width="100%">
                <tr>
                  <td>$lang[background]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_link_background]" value="$css[a_link_background]"></td>
                </tr>
                <tr>
                  <td>$lang[font_color]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_link_color]" value="$css[a_link_color]"></td>
                </tr>
                <tr>
                  <td>$lang[text_decoration]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_link_text_decoration]" value="$css[a_link_text_decoration]"></td>
                </tr>
              </table>
              </fieldset> </td>
              <td><fieldset>
              <legend>Visited Links</legend>
              <table width="100%"  class="tdf">
                <tr>
                  <td>$lang[background]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_visited_background]" value="$css[a_visited_background]"></td>
                </tr>
                <tr>
                  <td>$lang[font_color]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_visited_color]" value="$css[a_visited_color]"></td>
                </tr>
                <tr>
                  <td>$lang[text_decoration]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_visited_text_decoration]" value="$css[a_visited_text_decoration]"></td>
                </tr>
              </table>
              </fieldset> </td>
              <td><fieldset>
              <legend>Hovered Links</legend>
              <table width="100%" class="tdf">
                <tr>
                  <td>$lang[background]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_hover_background]" value="$css[a_hover_background]"></td>
                </tr>
                <tr>
                  <td>$lang[font_color]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_hover_color]" value="$css[a_hover_color]"></td>
                </tr>
                <tr>
                  <td>$lang[text_decoration]</td>
                  <td>
                  <input size="8" name="css[$tmp[title]][a_hover_text_decoration]" value="$css[a_hover_text_decoration]"></td>
                </tr>
              </table>
              </fieldset> </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td class="tcat" align="left" colSpan="2">
		<div class="td2" style="border:inset 1px; padding:2px 10px 2px 10px; float:left">CSS Selector: <code>$tmp[title]</code></div>
          <div style="FLOAT: right">
            <input type="submit" value="  $lang[save]  " name="Save Changes">&nbsp;&nbsp;
          </div>
          <div>
&nbsp;</div>
          </td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
<br><br>