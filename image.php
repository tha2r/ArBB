<?php
/*******************************************************************\
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
# @                      ArBB V 1.0.0 Beta 1                      @ #
# @       All Copyrights are saved Arabian bulletin board team    @ #
# @                   Copyright © 2009 ArBB Team                  @ #
# @         ArBB Is Free Bulletin Board and not for sale          @ #
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
\*******************************************************************/
#
#    image creator File started
#
/*
        File name       -> image.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='';
$phrasearray=array();
require('global.php');
require('./includes/class_gd.php');

$GD = new arbb_gd;

if($arbb->input['imagehash'] == 'test')
{
        $image_string = 'ArBB';
}
else
{
        $im = $DB->query_now("select * from "._PREFIX_."regimage where imagehash='".$DB->escape_string($arbb->input['imagehash'])."'");
        $image_string = $im['imagestring'];
        $DB->query("delete from "._PREFIX_."regimage where dateline<'".(TIMENOW-360)."'");
}

$fonts = array();
if(function_exists('imagefttext'))
{
        $fdir  = @opendir('./includes/regimage_fonts');
        if($fdir)
        {
                while($file = readdir($fdir))
                {
                        if(is_file('./includes/regimage_fonts/'.$file) && get_extension($file) == 'ttf')
                        {
                                $fonts[] = './includes/regimage_fonts/'.$file;
                        }
                }
        }
}

if(count($fonts) > 0)
{
        $use_ttf = 1;
}
else
{
        $use_ttf = 0;
}

// Check for GD >= 2, create base image
if($GD->gd_version() >= 2)
{
        $image = imagecreatetruecolor($GD->img_width, $GD->img_height);
}
else
{
        $image = imagecreate($GD->img_width, $GD->img_height);
}

// No GD support, die.
if(!$image)
{
        die('No GD support.');
}


$bg_color = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bg_color);


$draws = array('circles','squares','lines');


        $GD->draw($image,'dots');
        $GD->draw($image,$draws[array_rand($draws)]);



// Write the image string to the image
$GD->draw($image,$image_string);

// Draw a nice border around the image
$border_color = imagecolorallocate($image, 0, 0, 0);
imagerectangle($image, 0, 0, $GD->img_width-1, $GD->img_height-1, $border_color);

// Output the image
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
