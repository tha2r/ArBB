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
#    attachments File started
#
/*
        File name       -> attachment.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

// Used Templates list ,,

$templatelist='attachments_manage,attachments_typebit,attachments_attachmentbit';

$phrasearray = array('thread','attachments');

require('global.php');
$plugins->cache('attachment_start,attachment_display,attachment_delete,attachment_complete');
($evalp = $plugins->load('attachment_start'))?eval($evalp):'';
require('includes/class_upload.php');
if(empty($arbb->input['action']))
{
if($localgroup['candownattach']==0)
{
 error_permission();
}
  $atid=checkval($arbb->input['atid']);
        header('Content-Type:');
        header('X-Powered-By:');
  $query=$DB->query("select a.*,at.mimetype from "._PREFIX_."attachment a LEFT JOIN attachmenttype at on (at.extension=a.filetype) where a.atid='$atid'");
  while($at=$DB->fetch_array($query))
  {
     ($evalp = $plugins->load('attachment_display'))?eval($evalp):'';
     $DB->query("update "._PREFIX_."attachment set counter=counter+1 where atid='$at[atid]'");

        header("Content-disposition: filename=".$at['filename']."");
        header("Content-length: ".$at['filesize']."");
        header($at['mimetype']);

        if(eregi("cookie",$at['filedata']))
        {
         $at['filedata']=str_replace('script','scri pt',$at['filedata']);
         $at['filedata']=str_replace('document.cookie','document(.)cookie',$at['filedata']);
        }

        Echo $at['filedata'];

   die();
  }

  header('Content-type: image/gif');
  header('Content-disposition: filename=arbb_404.gif');
  header("Content-length: 2480");

Echo base64_decode('R0lGODlh+ABsANUgAP8AAICVxWB6t9Xc7PT2+v/v77/K4muDu6q42P9/f5Wnz//f39/'.
                   'k8XWMwOrt9bXB3crT5/+fn/9PT/+/v/8vL//Pz/8/P/+vr4qeyv8fH6Cv1P9vb/8PD/'.
                   '9fX/+Pj1Zysv///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'.
                   'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'.
                   'AAAAACH5BAEAACAALAAAAAD4AGwAAAb/QJBwSCwaj8ikcslsOp/QqHRKrVqv2Kx2y+1'.
                   '6v+CweEwum8/otHrNbrvf8Lh8Tq/b7/i8fs/v+/+AgYKDhIWGh4iJiouMjXAQARqOk5'.
                   'RHDAIfAW0OAZ2en6ChnhgICAMEUpyiq6ukpqiVZgQHH5ltkA21uru8vb4BBlC4vsTFu'.
                   'g3BsWO5tZqPmMbRuw0MUhDQ0tLUymAKu85wCNHVIA4GtMUC5FDixuTmzMTq3F0PvBhy'.
                   'BMYHRt7psE8IYOvFr4g/eQDpXTHQC8EcYwqOBIAohaKRicUiKrxyqaEcB8YgHBkQzQE'.
                   'UkMVEGiFpzORGKgJ9OYzDsFhCIgN7JXMCwdjN/yE5eT14OYVAPF4z4RzsBe6iMUlPlv'.
                   'JqWgQjMY1EoUjdlfQNOl9DkVj9BeVrr7ASjVHNuqQdMbRuGLRMEnQXPicoia0zYpYpW'.
                   'yc1iw2IY49YwSN5iXVdUtjXYSP6jC3+a6nursFwxvKCeiQwMZVNMGRM4tkXaMpHYkbD'.
                   '7Cby5ySaeT1mEjKJ6HSokxitZbkW61vGkiT2tZNJT5tIhnvMfeT2B5bEfkMZYEBDp+I'.
                   'OEAD7eWSrrrvNjTWAoqHY2iHejzE/Ur6WAeWXnwx4oOBoLdCNPwg4jaTvLrhEQOfLPE'.
                   '/4pwuAQwjYC4HrDRFYRArywoQB9RkjwBBu6TKbEXIV4/9SEQ70xmAT8Omy1xCqDXjie'.
                   'h1+cFeEu9AmjUbH9cLdEPnJZol933zoRI67bAgCAzwe42ODIdbSACww6vJEhryIlCIv'.
                   '0lVVDGc4WnZAcU841wtWWRrGZYO76fdhjb5AEVstQnjJy5FEuGaaEAQMoIGBLo75RG0'.
                   'g1HknMRjo2eBtI0Ip4ZO+4NMkm0mgydSavAV6I0/iQaqfpA0i0d4HXBoaY5fEgVCkkk'.
                   'qkF80B/FWxaTYaCpqpEIFN5impBfpCQGBBTUYEntk08MCkTvAqzQG/vloEdGBiaN4T8'.
                   'OFDy34gjCUAnEO06MsA2M6nQF0CIACsEtb2AkG29HGrwbdsdfT/wXhpEXMeEkB+8EBN'.
                   'yagrgKsgxEtrnOlBK4W+60LWL75ZlXnAjZa+G14vDtCCJQEaKEAtEZbqCoKpyTZhKZZ'.
                   'EzPpBxpRhNKKV7u7ZCzL6oQuZO7AVYzEScvZS5RAbr3fQzDQv24SjtTxAC8FI8KzLhU'.
                   'ks+twTQvOmhNE4b/RgtlBD/ZQTq+oijpBNYLxEbwr3Uwx4/RWDtUJGs1rLy0X4d8DPV'.
                   'PBKsKUfrBg2MW+znG5vZp9NomMfjL1EuLx8Czfa1c6lhJtIsWUwK6BI1kS8mAANbzHs'.
                   'KgF31zhSzsTlbIk8sRGOM4E4byofMeoHHLdb8uZXsq7zSzebrFgTLsNk/0zTQKnFRMx'.
                   'UMoE35o40JvkQxgCd9AefL1HaLkSDGw3wxzcv3PMv1QiybrczUfV3VZgK9uShl/o1Ew'.
                   'DXknol6gJ/bPZL4JnqE70BLWzcTLjNxOn3KTSLkqUnyP70jqkC4HaRPBCUzW9CGKAuC'.
                   'njAjTBjZE1gGmOIcT4neKxyScAfp8gntvtFY3iIiJ0Ulhcfy+mlCqerYObE04QUTpCF'.
                   '9NjU9ZjgsaNhb0BVKJFvnGchuRWBd7t4X7XwBsFJ4Kp/RRidLnCXtBlyUB7gwtsGn0i'.
                   'MKH6QHp75HhTwJkQhpKeL9RtfamronmCJETJknKIycuREJZDRiXhCIhHKxyUCQP9gW6'.
                   'fyoRHKByA74tFCuFOEA0YXyMpIQ1AKVF93otGAT5jtXE4wlZIcySpIxsIASqyFAhDAQ'.
                   'ARYx2wB4GQR9IWgopXiT3nThiiXdsr5pbJvq1QGqwKpQQ+RrBd6NEItWSWATmzyFE7Y'.
                   'ZTZ6GYBfFtBYyEymMpfJzGY685nQjKY0p0nNalrzmtjMpja3yc1uevOb4AynOMdJznK'.
                   'a85zoTKc618nOdrrzncwsQAIWIIQFJMADBSiCPOm5BHkm4J8ATQAILuABECwgAgmYgB'.
                   'IQmoAL1BOgT2BoQOeZhQJcIAEREGcBKAAAIVSAAxuQgASIsNGONuECAACABP7JAQuAI'.
                   'AP/AJjARwHg0CRUAKYcyGcBOpCBCti0CBXgaAb+ydF8YqEAEgDABsRpAZUKAaZINakQ'.
                   'mjrSJlQgpfxEKAgisNQCAIADTOAoAAQKgg3U9AgRoIARYErWjW6Boz4FJ08BkNEIOJW'.
                   'jQ5hrRolwUKMSIQEAyAAI5FmAAkzgAnV1aj09oFC+WqADgX3qECzqAXouALIdKMICUu'.
                   'rTpcb1oBEw6gQioNAJKHQBExBoBfAphAJEwK5gBecGOsBResI0Aps16WxrW4SkZrYIH'.
                   'KVAAjJQ0AU0NbNJzWgBLCABvBIhApVNKW6regEOeIACOd1ASl1KBA+kNAEW4C4IEsAB'.
                   'lLp0AtJF/6laIZsBuwKgoB+VwHHBGQEJbFatuT0oANRa3/saQbt7nWxKO6BdfjbVoRw'.
                   'AQGEpkIHNCpYIEvApez1QUPS6tKkyjWxvAWCB4RZ0vGMFQUoHm9ICaLeggM1AB5oa2g'.
                   'zk9MDfrO5FAdABw+4XBEn1gIwBW+MmuDefVfVqR81bVqUyOK5DUKtBU8oBenIUwQrW7'.
                   'lKLIN3x+lTIBbgqf1VagAT7lKMWwLJ3NyBkcDY1pZxF71KxemY0I7meR4CseIVg15Ge'.
                   'GAQcbagRJvBbEDT1wSNW70sB8OaBlpgIRJYyjumaVMHmF6UjPbB2q+rNCpg2sKWlqV1'.
                   'Ve+kMNHYIMP10a80T/OEh+NYDMDUrZ8cr6g6cVc1LdqkEOFCBzXIgAX4FAWSVPIRNd5'.
                   'kC+UxpcznsAbtmVs7VpXFKNxBgb6J0yn6WgIoRrVQjJPisIKhAUlUq6qYCO8HHRnOzJ'.
                   '81PP9d01sP16VWt+9eUtpekHKCAfI36Xe02ObmLlvV+vZ3rbqK23CCYAMANKnAjLKDQ'.
                   'SkBtPZGscCYAvNZEgPgTJpDrClyZ4vr89GkxDs+Oe/zjIA+5yEdO8pKb/OQoT7nKV87'.
                   'ylrv85TCPucxnTvOaSyEIADs=');
die();

}
elseif($arbb->input['action']=='manage')
{
$up = new arbb_upload;
        if(isset($arbb->input['pid']))
        {
         $pid=checkval($arbb->input['pid']);
         $posthash='postid';
         $where="postid='$pid'";
         $wheres="pid=$pid";

         $post=$DB->query_now("select p.postid,p.userid,p.threadid,t.forumid from "._PREFIX_."post p LEFT JOIN thread t on (t.threadid=p.threadid) where p.postid='$pid'");
         if(!is_moderator($post['forumid']))
         {
           if($post['userid'] != $local['userid'])
           {
               error_permission();
           }
         }

        }
        else
        {
         $fid=checkval($arbb->input['fid']);
         $posthash=$bbcode->clearhtml(addslashes($arbb->input['posthash']));
         $where="posthash='$posthash'";
         $wheres="posthash=$posthash";
         $pid='posthash';
        }

if($arbb->input['do']=='upload')
{
$upload = $up->upload_attachment($_FILES['attach'],$posthash,$pid);
if($upload['error']==1)
{
if(is_array($upload['errors']))
{
 $errors=implode("<li>",$upload['errors']);
 }
}

if($upload == 1)
{
 $alert=$lang['file_uploaded'];
}
}
elseif($arbb->input['do']=='delete')
{

 $atid=checkval($arbb->input['atid']);

      if($atid > 0)
      {
($evalp = $plugins->load('attachment_delete'))?eval($evalp):'';
        $upload = $up->delete_attachment($atid);
      }
}

        $attachtypes = '';
        $attachments = '';

        $query=$DB->query("select * from "._PREFIX_."attachment where $where");

        while($at = $DB->fetch_array($query))
        {
                   if($at['filesize']>1024)
                   {
                   $at['filesize']=ceil($at['filesize']/1024);
                   if($at['filesize']>1024)
                   {
                   $at['filesize']=ceil($at['filesize']/1024)."&nbsp;MB";
                   }
                   else
                   {
                   $at['filesize'].="&nbsp;KB";
                   }
                   }
                   else
                   {
                    $at['filesize'].="&nbsp;Byte";
                   }

            $at['img']="<img src=\"images/attach/$at[filetype].gif\">";
            $attachments .= $TP->gettemp('attachments_attachmentbit');
            $pattachments.="  -> $at[img] $at[filename] ($at[filesize])<br>";
        }

        $query=$DB->query("select * from "._PREFIX_."attachmenttype");

        while($atype = $DB->fetch_array($query))
        {

                   if($atype['maxsize']>=1024)
                   {
                   $size=floor($atype['maxsize']/1024);
                   $atype['maxsize']=$size."&nbsp;MB";
                   }
                   else
                   {
                   $atype['maxsize'].="&nbsp;KB";
                   }

            $atype['img']="<img src=\"images/attach/$atype[extension].gif\">";
            $attachtypes .= $TP->gettemp('attachments_typebit');
        }
        $page=$TP->gettemp('attachments_manage');
}
($evalp = $plugins->load('attachment_complete'))?eval($evalp):'';
print_page($page);
?>