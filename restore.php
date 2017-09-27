<?php
require_once "config.php";

use Nucleus\DB;
use Nucleus\TPL;
use Nucleus\Authorization;
use Nucleus\Mail;

$db = DB::getInstance();
$tpl = new TPL();
$act = $_GET['act'];

$tpl->file("restore/main.TPL");

function genPassword() {
   $server_time = $_SERVER['REQUEST_TIME'];
   $salt = "restore-pass_" . rand(555555, 999999);
   $password = md5($server_time . $salt);

   return substr((new Authorization())->passD($password), 0, 15);
}

function hashPassword($p) {
  return (new Authorization())->passD($p);
}

switch ($act) {
  case "r":
    $email = $db->escapeString($_GET['email']);
    $query = "SELECT id, email, first_name, last_name FROM users WHERE email_ver = 1 AND email = '" . $email . "'";
    $resultQuery = $db->query($query);
    if ($db->numRows($resultQuery) == 0) {
      $tpl->template("restore/no-user.TPL");
      $tpl->complete("content");
    } else {
      //parse info
      $fetch = $db->fetch($resultQuery);
      $image = "/upload/" . $fetch['id'] . "/photo/photo-profile.jpg";
      if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $image)) $image = "/tpl/img/no-photo-profile.png";
      $name = $fetch['first_name'] . " " . $fetch['last_name'];
      $_SESSION['restore_id'] = $fetch['id'];
      $_SESSION['email'] = $email;

      $tpl->template("restore/user.TPL");
      $tpl->parse_tpl("{image}", $image, true);
      $tpl->parse_tpl("{name}", $name, true);
      $tpl->complete("content");
    }
    $db->free($resultQuery);
    break;

  case "finish":
    if (!$_SESSION['restore_id']) header("Location: /restore");
    $tpl->template("restore/finish.TPL");
    $tpl->complete("content");

    $rID = $_SESSION['restore_id'];
    $newPassword = genPassword();
    $newPasswordHash = hashPassword($newPassword);
    $restorePasswordQuery = "UPDATE users SET password = '" . $newPasswordHash . "' WHERE id = $rID";
    $resultQuery = $db->query($restorePasswordQuery);

    //mail
    $_SESSION['new_password'] = $newPassword;
    $mail = new Mail($_SESSION['email'], 7);
    break;

  default:
    $tpl->template("restore/form.TPL");
    $tpl->complete("content");
    break;
}

$tpl->print_file();
$tpl->clear();
