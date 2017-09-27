<?php

namespace Nucleus;

require "config.php";

$id = (int) $_SESSION['id'];
$act = $_GET['act'];

if (!$id) {
  echo -1;
  return;
}

$db = DB::getInstance();
$tpl = new TPL();

$user_info_query = "SELECT email, email_ver FROM users WHERE id = $id";
$result_user_info = $db->query($user_info_query);
$fetch_info = $db->fetch($result_user_info);


switch ($act) {
  case "email_ver":
    if ($fetch_info['email_ver'] == 0) {
      $tpl->file("status/email_ver.TPL");
      $tpl->print_file();
    } else {
      die("0");
    }
    break;

  case "sendEmailVer":
    if ($fetch_info['email_ver'] == 1) return;

    $mail = new Mail($fetch_info['email'], 0);
    if ($mail) die("0");
    else die("1");
    break;
}

$db->free($result_user_info);
