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
#              Uploading Class started
#  Used For attachments and avatars and other staff ,,
#
/*
        File name       -> class_upload.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Class
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

Class arbb_upload{

// Start Variables Which will be used here

        var $uploads = array();
        var $upload_path    = '';

// End Variables Which will be used here :)


             function upload_avatar($avatar)
             {
                     GLOBAL $DB,$lang,$localgroup,$local;

                     if(!is_uploaded_file($avatar['tmp_name']))
                     {
                          error_message($lang['error_avatar_upload_failed']);
                     }

                     $allowed_ext=array('gif','jpg','jpeg','png');
                     $ext=get_extension($avatar['name']);

                     if(!in_array($ext,$allowed_ext))
                     {
                          error_message($lang['error_avatar_type']);
                     }

                     $dim=getimagesize($avatar['tmp_name']);
                     if(!is_array($dim))
                     {
                        error_message($lang['error_avatar_upload_failed']);
                     }

                     if(($dim[0] == 0)||($dim[1]==0))
                     {
                         error_message($lang['error_avatar_type']);
                     }

                     if(($dim[0] > $localgroup['avatarmaxwidth']) ||($dim[1] > $localgroup['avatarmaxheigh']))
                     {
                      eval("\$lang['error_avatar_upload_size']=\"".$lang['error_avatar_upload_dim']."\";");
                       error_message($lang['error_avatar_upload_size']);
                     }



                     $filename='avatar_'.$local['userid'].'.'.$ext;
                     $path = $this->upload_path.'/'.$filename;

                         if(file_exists($path))
                         {
                          unlink($path);
                         }

                     $up = $this->upload_file($avatar,$filename);
                     if(!$up)
                     {
                             return $up;
                     }
                     else
                     {
                        $title = str_replace('_',' ',$avatar['name']);
                        $title = str_replace('.'.$ext,'',$title);



                        $ins = $DB->query("insert into "._PREFIX_."avatar (title,path,catid) VALUES ('$title','$path','4')");

                        return $DB->insert_id($ins);

                     }


             }


             function upload_file($file,$filename)
             {

                      if(empty($file['name']) || $file['size'] <1)
                      {

                              return 0;
                      }

                      if(empty($filename))
                      {
                         $filename=$file['name'];
                      }
                       $filename=preg_replace("#/$#","",$filename);

                      $upload = move_uploaded_file($file['tmp_name'], $this->upload_path."/".$filename);

                       if(!$upload)
                       {
                           return 0;
                       }
                       chmod($this->upload_path.'/'.$filename, 0777);
                       return 1;


             }

             function upload_attachment($file,$posthash,$pid)
             {

             GLOBAL $lang,$DB,$localgroup;
             $error=0;
             $errors=array();

             if(!is_numeric($pid))
             {
             $where = "posthash='$posthash'";

             }
             else
             {
              $where = "postid='$pid'";
             }

             if($localgroup['attachlimit'] > 0)
             {

                   $attach = $DB->query("select * from "._PREFIX_."attachment where $where");
                   $attachs=$DB->num_rows($attach);

                   if($localgroup['attachlimit'] <= $attachs)
                   {
                      $errors[]=$lang['attachments_max_reached'];
                      return array("error" => 1,"errors" => $errors);
                   }

             }
              if($file['error'] != 0 && $file['error'] != "")
              {
              $error=1;
               switch($file['error'])
               {
                       case '1';
                       case '4';
                       $errors[]=$lang['upload_error_nothing_to_move'];
                       break;
                       case '2';
                       case '3';
                       $errors[]=$lang['upload_error_failed'];
                       break;
                       default;
                       $errors[]=$lang['upload_error_failed'];
                       break;
               }

               return array('error' => 1,'errors' => $errors);
              }

              $error=5;
                $filename=preg_replace("#/$#","",$file['name']);
                $ext=get_extension($filename);
                $qu=$DB->query("select * from "._PREFIX_."attachmenttype where extension='$ext'");
                while($ex=$DB->fetch_array($qu))
                {
                 $error=0;
                 $dim=getimagesize($file['tmp_name']);

                if($ex['maxwidth']&&$ex['maxheigh'])
                {
                     $dim=getimagesize($file['tmp_name']);

                     if(!is_array($dim))
                     {
                      $error=1;
                      $errors[]=$lang['error_image_type_dims'];
                     }

                     if(($dim[0] == 0)||($dim[1]==0))
                     {
                     $error=1;
                      $errors[]=$lang['error_image_type_dims'];
                     }

                     if(($dim[0] > $ex['maxwidth']) ||($dim[1] > $ex['maxheigh']))
                     {
                     $error=1;
                      eval("\$errors[]=\"".$lang['error_image_upload_size']."\";");

                     }
                }
                     if((($dim[0] == 0)||($dim[1]==0))&&eregi('image',$ex['mimetype']))
                     {
                      $error=1;
                      $errors[]=$lang['error_image_type_dims'];
                     }

                if($file['size']>$ex['maxsize']*1024 && $ex['maxsize'] != '0')
                {
                        $error=1;
                        $errors[]=$lang['error_upload_file_size'];

                }


                 $thumbnail='';


                }

                if($error != 0)
                {

                if($error==5)
                {
                  $errors[]=$lang['wrong_file_extension'];
                }
                  return array('error' => 1,'errors' => $errors);
                }

                $query=$DB->query("select * from "._PREFIX_."attachment where $where and filename='$filename'");
                $ex=$DB->num_rows($query);

                if($ex > 0)
                {
                  $errors[]=$lang['file_already_uploaded'];
                  return array('error' => 1,'errors' => $errors);
                }

                $filedata=file_get_contents($file['tmp_name']);

               $ins=array('userid'     => $local['userid'],
                          'dateline'   => TIMENOW,
                          'filename'   => $filename,
                          'filedata'   => addslashes($filedata),
                          'visible'    => '1',
                          'counter'    => '0',
                          'filesize'   => $file['size'],
                          'postid'     => $pid,
                          'posthash'   => $posthash,
                          'thumbnail'  => $thumbnail,
                          'filetype'   => $ext);
              $ins=$DB->multible_insert($ins,'attachment');
              if(!$ins)
              {
                  $errors[]=$lang['upload_error_failed'];
                  return array('error' => 1,'errors' => $errors);

              }
              else
              {
               return 1;
              }
             }

             function delete_attachment($atid)
             {
                GLOBAL $DB;
                $DB->query("DELETE FROM "._PREFIX_."attachment WHERE atid='$atid'");
             }

              }
//# All Done .. Upload Class Finished
?>