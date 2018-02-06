
	
<form action="maintenance.php?do=do_counter_stats&sid=$sid" method="post">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td>
	$lang[recount_statistics]</td>
    </tr>
	<tr class="td1">
		<td>$lang[recount_statistics_note]</td>
			</tr>
	<tr class="thead" align="center">
		<td width="100%">
      <input type="submit" value="$lang[recount]"></td>
			</tr>
	</table>
</form>
<br>

	
<form action="maintenance.php?do=do_counter_forums&sid=$sid" method="post">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td>
	$lang[recount_forums_counters]</td>
    </tr>
	<tr class="td1">
		<td>$lang[recount_forums_counters_note]</td>
			</tr>
	<tr class="td1">
		<td>$lang[forums_perpage] - 
        <input type="text" name="perpage" size="5" value="20"></td>
			</tr>
	<tr class="thead" align="center">
		<td width="100%">
      <input type="submit" value="$lang[recount]"></td>
			</tr>
	</table>
</form>
<br>

	
<form action="maintenance.php?do=do_counter_posts&sid=$sid" method="post">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td>
	$lang[rebuild_posts]</td>
    </tr>
	<tr class="td1">
		<td>$lang[rebuild_posts_note]</td>
			</tr>
	<tr class="td1">
		<td>$lang[posts_perpage] - 
        <input type="text" name="perpage" size="5" value="500"></td>
			</tr>
	<tr class="thead" align="center">
		<td width="100%">
      <input type="submit" value="$lang[update]"></td>
			</tr>
	</table>
</form>
<br>
<form action="maintenance.php?do=do_counter_threads&sid=$sid" method="post">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td>
	$lang[rebuild_threads]</td>
    </tr>
	<tr class="td1">
		<td>$lang[rebuild_threads_note]</td>
			</tr>
	<tr class="td1">
		<td>$lang[threads_perpage] - 
        <input type="text" name="perpage" size="5" value="500"></td>
			</tr>
	<tr class="thead" align="center">
		<td width="100%">
      <input type="submit" value="$lang[update]"></td>
			</tr>
	</table>
</form>
<br>

	
<form action="maintenance.php?do=do_counter_users&sid=$sid" method="post">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td>
	$lang[recount_users_count]</td>
    </tr>
	<tr class="td1">
		<td>$lang[recount_users_count_note]</td>
			</tr>
	<tr class="td1">
		<td>$lang[users_perpage] - 
        <input type="text" name="perpage" size="5" value="500"></td>
			</tr>
	<tr class="thead" align="center">
		<td width="100%">
      <input type="submit" value="$lang[update]"></td>
			</tr>
	</table>
</form>
<br>
<div align="center">
<br><br>
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>
        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>