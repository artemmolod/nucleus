<?php
   require "config.php";

   use Nucleus\DB;
   use Nucleus\TPL;

   $id  = $_SESSION['id'];

   if (!$id)
      header("Location: /");

   $db  = DB::getInstance();
   $tpl = new TPL();

   $result = $db->query("SELECT first_name, last_name, email FROM users WHERE id = $id");
   $fetch  = $db->fetch($result);

   if ($fetch['first_name'] != "" AND $fetch['last_name'] != "") header("Location: /");

   if (!empty($_GET['fname']) && !empty($_GET['lname']) && !empty($_GET['bdate']) && !empty($_GET['sex'])) {
       $fname = iconv("UTF-8", "windows-1251", $db->escapeString($_GET['fname']));
       $lname = iconv("UTF-8", "windows-1251", $db->escapeString($_GET['lname']));
       $bdate = $db->escapeString($_GET['bdate']);
       $sex   = (int) $db->escapeString($_GET['sex']);

       $query = "UPDATE users SET first_name = '".$fname."', last_name = '".$lname."', bdate = '".$bdate."', sex = $sex WHERE id = $id";
       $update_res = $db->query($query);
       if ($update_res) {
          die("done");
          exit();
       } else {
          die("Error");
          exit();
       }
   }

   $tpl->file("registration_info.TPL");

   //email
   $tpl->parse_tpl("{email}", $fetch['email']);
   $tpl->parse_tpl("{id}", $id);
   $db->free($result);

   $tpl->print_file();
   $tpl->clear();
