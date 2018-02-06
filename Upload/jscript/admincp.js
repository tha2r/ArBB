/**
 *  Arbb 1.0.0 (beta 1)  
 *  All Copyrights are saved Arabian bulletin board team
 *  Copyright © 2009 ArBB Team
 *  ArBB Is Free Bulletin Board and not for sale 
**/

//#
//#    ArBB_global java script File started
//#
/*
        File name       -> ArBB_global.js
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Java Script Functions
*/

function style_go(styleid)
{
 style = document.getElementById('menu_'+styleid);

 window.location='style.php?styleid='+styleid+'&do='+style.value+'';
}

function lang_go(langid)
{
 lang = document.getElementById('lang_'+langid);

 window.location='lang.php?langid='+langid+'&do='+lang.value+'';

}

function increase_textarea(textareaid)
{
	var textarea = document.getElementById(textareaid);
	var textarea_cols=textarea.cols + 10;
	var textarea_rows=textarea.rows + 5;
	
	textarea.rows=textarea_rows;
	textarea.cols=textarea_cols;	
}

function decrease_textarea(textareaid)
{
	var textarea = document.getElementById(textareaid);
	var textarea_cols=textarea.cols - 10;
	var textarea_rows=textarea.rows - 5;
	if(textarea.rows > 5)
	{
	textarea.rows=textarea_rows;
	textarea.cols=textarea_cols;	
	}
}
