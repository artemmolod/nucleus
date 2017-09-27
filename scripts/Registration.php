<?php
   namespace Nucleus;

   use Nucleus\DB;

   class Registration
   {
      /**
      * @var Error
      * 0 - Registration done
      * 1 - Registration failed
      * 2 - Email registered
      */
      private $err = 1;
      /****/
      public function __construct($email, $pass) {
          if ($email == false && $pass == false) return;
          
          $db = DB::getInstance();
          $email = $db->escapeString($email);
          $pass  = $db->escapeString($pass);

          if (strlen($email) == 0 || strlen($email) < 6 || strlen($pass) == 0 || strlen($pass) < 6) return false;

          $password = $this->getHashPassword($pass);

          //select email {$email} && Registration user
          $query_select_email = "SELECT email FROM users WHERE email = '".$email."'";
          $result_select = $db->query($query_select_email);
          $num_select_email = $db->numRows($result_select);

          if ($num_select_email != 0) {
               $this->err = 2;
          } else {
               $query  = "INSERT INTO `users`(`email`, `password`, `email_ver`) VALUES ('".$email."', '".$password."', 0)";
               $result = $db->query($query);

               if ($result) {
                   $query_id = "SELECT id FROM users WHERE email = '".$email."' AND password = '".$password."'";
                   $result_  = $db->query($query_id);
                   $arr_     = $db->fetch($result_);
                   $_SESSION['id'] = $arr_['id'];
                   $db->free($result_);
                   $this->err = 0;
               } else {
                   $this->err = 1;
               }

               $db->free($result);
          }
      }

      public function getError() {
          return $this->err;
      }

      private function getHashPassword($p) {
          $p = md5($p);
          for ($i = 0; $i < 5; $i++) {
              $p .= md5($p.$i);
          }
          $p = hash("sha256", $p);
          $p = md5($p);
          return $p;
      }
   }
