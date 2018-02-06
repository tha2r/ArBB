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
#    Gd Image handler Class started
#
/*
        File name       -> class_gd.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Class
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

Class arbb_gd{

// Start Variables Which will be used here

         var $img_width = 200;
         var $img_height = 60;

         var $min_size = 25;
         var $max_size = 32;

         var $min_angle = -30;
         var $max_angle = 30;

// End Variables Which will be used here :)



            function draw($image,$type)
            {

                     switch($type)
                     {

                     case 'lines';
                       $this->draw_lines($image);
                     break;
                     case 'circles';
                       $this->draw_circles($image);
                     break;
                     case 'dots';
                       $this->draw_dots($image);
                     break;
                     case 'squares';
                       $this->draw_squares($image);
                     break;
                     default;
                       $this->draw_string($image,$type);
                     break;
                     }

            }

            function draw_lines(&$image)
            {

                    for($i = 10; $i < $this->img_width; $i += 10)
                    {
                            $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
                            imageline($image, $i, 0, $i, $this->img_height, $color);
                    }
                    for($i = 10; $i < $this->img_height; $i += 10)
                    {
                            $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
                            imageline($image, 0, $i, $this->img_width, $i, $color);
                    }
              }

              function draw_circles(&$image)
              {
                    $circles = $this->img_width*$this->img_height / 100;
                    for($i = 0; $i <= $circles; $i++)
                    {
                            $color = imagecolorallocate($image, rand(180, 255), rand(180, 255), rand(180, 255));
                            $pos_x = rand(1, $this->img_width);
                            $pos_y = rand(1, $this->img_height);
                            $circ_width = ceil(rand(1, $this->img_width)/2);
                            $circ_height = rand(1, $this->img_height);
                            imagearc($image, $pos_x, $pos_y, $circ_width, $circ_height, 0, rand(200, 360), $color);
                    }
              }

              function draw_dots(&$image)
              {
                    $ceil = $this->img_width*$this->img_height/7;
                    for($i = 0; $i <= $ceil; $i++)
                    {
                            $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
                            imagesetpixel($image, rand(0, $this->img_width), rand(0, $this->img_height), $color);
                    }
              }

              function draw_squares(&$image)
              {

                    $square = 30;
                    for($i = 0; $i <= $square; $i++)
                    {
                            $color = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
                            $pos_x = rand(1, $this->img_width);
                            $pos_y = rand(1, $this->img_height);
                            $sq_width = $sq_height = rand(10, 20);
                            $pos_x2 = $pos_x + $sq_height;
                            $pos_y2 = $pos_y + $sq_width;
                            imagefilledrectangle($image, $pos_x, $pos_y, $pos_x2, $pos_y2, $color);
                    }
              }



              function draw_string($image,$string)
              {
                     GLOBAL $use_ttf,$fonts;

                    $spacing = $this->img_width / strlen($string);
                    $string_length = strlen($string);
                    for($i = 0; $i < $string_length; $i++)
                    {
                            if($use_ttf)
                            {

                                    $font_size = rand($this->min_size, $this->max_size);

                                    $font = array_rand($fonts);
                                    $font = $fonts[$font];

                                    $rotation = rand($this->min_angle, $this->max_angle);

                                    $r = rand(0, 150);
                                    $g = rand(0, 150);
                                    $b = rand(0, 150);
                                    $color = imagecolorallocate($image, $r, $g, $b);

                                    $dimensions = imageftbbox($font_size, $rotation, $font, $string[$i], array());
                                    $string_width = $dimensions[2] - $dimensions[0];
                                    $string_height = $dimensions[3] - $dimensions[5];

                                    $pos_x = $spacing / 4 + $i * $spacing;
                                    $pos_y = ceil(($this->img_height-$string_height/2));

                                    if($pos_x + $string_width > $this->img_width)
                                    {
                                            $pos_x = $pos_x - ($pos_x - $string_width);
                                    }

                                    // Draw a shadow
                                    $shadow_x = rand(-3, 3) + $pos_x;
                                    $shadow_y = rand(-3, 3) + $pos_y;
                                    $shadow_color = imagecolorallocate($image, $r+20, $g+20, $b+20);
                                    imagefttext($image, $font_size, $rotation, $shadow_x, $shadow_y, $shadow_color, $font, $string[$i]);

                                    // Write the character to the image
                                    imagefttext($image, $font_size, $rotation, $pos_x, $pos_y, $color, $font, $string[$i]);
                            }
                            else
                            {
                                    // Get width/height of the character
                                    $string_width = imagefontwidth(5);
                                    $string_height = imagefontheight(5);

                                    // Calculate character offsets
                                    $pos_x = $spacing / 4 + $i * $spacing;
                                    $pos_y = $this->img_height / 2 - $string_height -10 + rand(-3, 3);

                                    if($this->gd_version() >= 2)
                                    {
                                            $temp_im = imagecreatetruecolor(15, 20);
                                    }
                                    else
                                    {
                                            $temp_im = imagecreate(15, 20);
                                    }
                                    $bg_color = imagecolorallocate($temp_im, 255, 255, 255);
                                    imagefill($temp_im, 0, 0, $bg_color);
                                    imagecolortransparent($temp_im, $bg_color);

                                    // Set the colour
                                    $r = rand(0, 200);
                                    $g = rand(0, 200);
                                    $b = rand(0, 200);
                                    $color = imagecolorallocate($temp_im, $r, $g, $b);

                                    // Draw a shadow
                                    $shadow_x = rand(-1, 1);
                                    $shadow_y = rand(-1, 1);
                                    $shadow_color = imagecolorallocate($temp_im, $r+50, $g+50, $b+50);
                                    imagestring($temp_im, 5, 1+$shadow_x, 1+$shadow_y, $string[$i], $shadow_color);

                                    imagestring($temp_im, 5, 1, 1, $string[$i], $color);

                                    imagecopyresized($image, $temp_im, $pos_x, $pos_y, 0, 0, 40, 55, 15, 20);
                                    imagedestroy($temp_im);
                            }
                    }
              }





            function gd_version()
            {
                    static $gd_version;

                    if($gd_version)
                    {
                            return $gd_version;
                    }
                    if(!extension_loaded('gd'))
                    {
                            return;
                    }

                    ob_start();
                    phpinfo(8);
                    $info = ob_get_contents();
                    ob_end_clean();
                    $info = stristr($info, 'gd version');
                    preg_match('/\d/', $info, $gd);
                    $gd_version = $gd[0];

                    return $gd_version;
            }



              }
//# All Done .. Gd Image handler Class Finished
?>