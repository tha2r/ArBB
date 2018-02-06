$stylevar[htmldoctype]
<html dir="$lang[dir]" lang="$lang[code]">
<head>
	<meta http-equiv="Refresh" content="2; URL=$url" />
	<meta http-equiv="Content-Type" content="text/html; charset=$stylevar[charset]">
	<meta name="generator" content="$IN_ARBB">
	<meta name="keywords" content="$options[metakeys]">
	<meta name="description" content="$options[metadescription]">
	<LINK href="../cpstyles/$cpstyle[dir]/controlpanel.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="jscript/admincp.js"></script>
<title>$options[sitetitle]</title>
</head>
<body>

<br />
<br />
<br />
<br />

<form action="$url" method="post" name="redirection_form">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="70%" align="center">
<tr>
	<td class="tcat">$lang[redirecting]</td>
</tr>
<tr>
	<td class="td2" align="center">
	<div class="td1">
			<p>&nbsp;</p>
			<p><strong>$redirect_message</strong></p>			
				<p class="smallfont"><a href="$url">$lang[click_if_browser_does_not_redirect]</a></p>
				<div>&nbsp;</div>
	</div>
	</td>
</tr>
</table>
</form>
</body>
</html>