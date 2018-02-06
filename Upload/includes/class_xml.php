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
#    XML Classes started
#
/*
        File name       -> class_xml.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> class
*/
if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}
#
#     Xml classes ,, used to export and import forum contents
#         like language and style and forum settings ETC.
#
/******************************************************/
    /*/
    /*
    /*       This class is for reading xml files and resign
    /*              file or variable to php variables
    /*
    /*/

Class arbb_xml
{
// Start Variables Which will be used here
var $parser;
var $data = '';
var $parseddata = array();
var $stack = array();
var $cdata = '';
var $tag_count = 0;
// End Variables Which will be used here :)


/****************************************************/
              function xml($xml, $path = '')
              {
                      $this->data = '';
                      $this->stack = array();
                      $this->cdata = '';

                      if (($xml !== false)&&($xml !== ''))
                      {
                              $this->data = $xml;
                      }
                      else
                      {

                         $this->data = @file_get_contents($path);

                      }


                      if(!$this->data)
                      {
                       return false;
                      }

              }

              function &parse($encoding = 'ISO-8859-1')
              {
                      if (empty($this->data))
                      {
                              return false;
                      }

                      $this->parser = xml_parser_create($encoding);

                      xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 0);
                      xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
                      xml_set_character_data_handler($this->parser, array(&$this, 'cdata'));
                      xml_set_element_handler($this->parser, array(&$this, 'start'), array(&$this, 'end'));

                      xml_parse($this->parser, $this->data);
                      $err = xml_get_error_code($this->parser);

                      if ($err)
                      {
                              return false;
                      }

                      xml_parser_free($this->parser);

                      return $this->parseddata;
              }

              function cdata(&$parser, $data)
              {
                      $this->cdata .= $data;
              }

              function start(&$parser, $name, $attribs)
              {
                      $this->cdata = '';
                      array_unshift($this->stack, array('name' => $name, 'attribs' => $attribs, 'tag_count' => ++$this->tag_count));
              }

              function end(&$parser, $name)
              {
                      $tag = array_shift($this->stack);
                      if ($tag['name'] != $name)
                      {

                              return;
                      }

                      $output = $tag['attribs'];

                      if (trim($this->cdata) !== '' OR $tag['tag_count'] == $this->tag_count)
                      {
                              if (sizeof($output) == 0)
                              {
                                      $output = $this->cdata;
                              }
                              else
                              {
                                      $this->resign($output, 'value', $this->cdata);
                              }
                      }

                      if (isset($this->stack[0]))
                      {
                              $this->resign($this->stack[0]['attribs'], $name, $output);
                      }
                      else
                      {
                              $this->parseddata = $output;
                      }


                      $this->cdata = '';
              }

              function resign(&$resignvalue, $name, $value)
              {
                      if (!is_array($resignvalue) OR !in_array($name, array_keys($resignvalue)))
                      {
                              $resignvalue[$name] = $value;
                      }
                      else if (is_array($resignvalue[$name]) AND isset($resignvalue[$name][0]))
                      {
                              $resignvalue[$name][] = $value;
                      }
                      else
                      {
                              $resignvalue[$name] = array($resignvalue[$name]);
                              $resignvalue[$name][] = $value;
                      }
              }

}

    /*/
    /*
    /*       This class is for writing php values into xml files or variables
    /*
    /*/
Class arbb_xml_writer
{
// Start Variables Which will be used here
var $data = '';
var $charset = 'windows-1256';
var $content_type = 'text/xml';
var $space='';
// End Variables Which will be used here :)


/****************************************************/

              function xml($content_type = null, $charset = null)
              {
                if ($content_type)
                {
                        $this->content_type = $content_type;
                }

               $this->charset = (strtolower($charset) == 'iso-8859-1') ? 'windows-1256' : $charset;
              }

              function send_headers()
              {
                 header('Content-Type: ' . $this->content_type . ($this->charset == '' ? '' : '; charset=' . $this->charset).";");
                 $this->data = '<?xml version="1.0" encoding="' . $this->charset . '"?>';
              }

              function add_tag($tag,$array=array())
              {
                 $this->data.="\n".$this->space."<$tag".$this->fetch_tag($array).">";
                 $this->space.="\t";

              }

              function close_tag($tag)
              {
               $this->space = substr($this->space,0,-1);
               $this->data.="\n".$this->space."</$tag>";
              }

              function add_data($tag, $value = '', $array,$cdata=false)
              {
              $value=trim($value);
                 if($cdata!==false)
                 {
                    $this->data.="\n".$this->space.'<'.$tag.$this->fetch_tag($array).'><![CDATA['.$value.']]></'.$tag.'>';
                 }
                 else
                 {
                    $this->data.="\n".'<'.$tag.$this->fetch_tag($array).'>'.$value.'</'.$tag.'>';
                 }
              }

              function fetch_tag($array)
              {
              $ret='';
                 foreach($array as $key => $val)
                 {
                  $ret.=" $key=\"$val\"";
                 }
                 return $ret;

              }

              function print_data()
              {
               Echo $this->data;
               die();
              }


}
//# All Done .. XML (classes) Finished
?>