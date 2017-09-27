<?php

require_once "system/APIconfig.php";

$str_arr = [
  "api" => [
    "version" => API_VERSION,
    "close"   => API_CLOSE
  ]
];

print json_encode($str_arr);
