<html dir="$lang[dir]" lang="$lang[code]">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=$stylevar[charset]">
<meta name="generator" content="Microsoft FrontPage 5.0">
<meta name="keywords" content="$options[metakeys]">
<meta name="description" content="$options[metadescription]">
<LINK href="../cpstyles/$cpstyle[dir]/controlpanel.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../jscript/admincp.js"></script>
<script type="text/javascript" src="../jscript/arbb_global.js"></script>
        <title>$titleetc $options[sitetitle] - $lang[admin_control_panel]</title>
        <script type="text/javascript">
        function set_title()
        {
         parent.document.title = (document.title != '' ? document.title : 'Arbb Admin Control Panel');
        }
        </script>
        
</head>
<if condition="$show[bodytag]">
<body onload="set_title();">
</if>
<if condition="$show[location_bar]">
<!-- user info and location -->
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">
<tr>
	<td width="100%" class="td1">
				<a href="index.php?action=main&sid=$sid">$lang[admin_control_panel]</a> $nav[locatio]
	</td>	
</tr>
</table>
</if>
$options[webcontent]
</body>
</html>