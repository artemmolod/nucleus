<?php 

namespace Nucleus;

require "config.php";

$db = DB::getInstance();

$act = $_GET['act'];

switch ($act) {
  case "email_ver":
    $hash = (string) $_GET['hash'];
    if ($hash == $_SESSION['hash_email_ver']) {
      $id = $_SESSION['id'];
      if (!$id) return;
      $query_update = "UPDATE users SET email_ver = 1, rating = rating + 10 WHERE id = $id";
      $result = $db->query($query_update);

      $mail = new Mail($new_email, 1);

      if ($result) {
        header("Location: /");
      }
    }
    break;
}