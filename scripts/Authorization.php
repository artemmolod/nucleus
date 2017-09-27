<?php
   namespace Nucleus;

   use Nucleus\DB;
   use Nucleus\Registration;

   class Authorization
   {
       /**
       * @var Err - Error Authorization
       * 0 - Authorization Done
       * 1 - User not found
       * 2 or 3 - user bloking or deleted
       */
       private $err;

       public static function getAuth() {
          if (isset($_SESSION['id'])) return true;
          else return false;
       }

       public function auth($email, $pass) {
          $db = DB::getInstance();

          $email = $db->escapeString($email);
          $pass  = $db->escapeString($pass);

          $password = $this->getHashPassword($pass);

          $query_auth  = "SELECT id, block, del FROM users WHERE email = '".$email."' AND password = '".$password."'";
          $result_auth = $db->query($query_auth);
          $fetch_u     = $db->fetch($result_auth);
          $numRows_    = $db->numRows($result_auth);

          //user not found
          if ($numRows_ == 0) {
              $this->err = 1;
              return;
          }

          //user bloking or deleted
          if ($fetch_u['block'] == 1) {
              $this->err = 2;
              return;
          } else if ($fetch_u['del'] == 1) {
			        $this->err = 3;
			        return;
		      }

          //auth done
          $_SESSION['id'] = $fetch_u['id'];
          $this->err = 0;
          $db->fetch($result_auth);

          $off_user_query = "UPDATE users SET off = 0 WHERE id = {$fetch_u['id']}";
          $db->query($off_user_query);
          return;
       }

       public function passD($pass) {
            return $this->getHashPassword($pass);
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

       public function getError() {
          return $this->err;
       }
   }
