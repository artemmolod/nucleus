<?php
require "config.php";

$src = "/upload/1/photo/jsjsssksksksk.jpg";
$arr[] = explode("/", $src);
   $cnt_arr = count($arr[0]);
              $cnt = $cnt_arr - 1;
              list($name_image_, ) = explode(".", $arr[0][$cnt]);
              print $new_name_image_album = $name_image_ . "-album";