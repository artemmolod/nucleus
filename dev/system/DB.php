<?php
    class DB
    {
         private $bd;
         private $connect;

         private $defaults = [
             'host' => "mysql.hostinger.ru",
             "user" => "u116083079_nucl",
             "pass" => "o9bY18H4Tu",
             "bd"   => "u116083079_nucl",
             "charset" => "utf8",
         ];

         private static $instance = null;

         public static function getInstance() {
           if (null === self::$instance) {
             self::$instance = new self();
           }
           return self::$instance;
         }

         private function __clone() {}

         private function __construct($opt = []) {
             $opt = array_merge($this->defaults, $opt);

             $this->connect = mysqli_connect($opt['host'], $opt['user'], $opt['pass'], $opt['bd']);
             if (!$this->connect) {
                 $this->error(mysqli_connect_errno()." ".mysqli_connect_error());
             }
             mysqli_set_charset($this->connect, $opt['charset']) or $this->error(mysqli_error($this->conn));
         }

         public function query($query) {
             $res = mysqli_query($this->connect, $query);
             if (!$res) {
                $error = mysqli_error($this->connect);
                $this->error("$error. Full query: $query");
                return;
             }
             return $res;
         }

         public function fetch($res) {
             return mysqli_fetch_array($res, MYSQLI_BOTH);
         }

         public function numRows($res) {
             return mysqli_num_rows($res);
         }

         public function free($res) {
             return mysqli_free_result($res);
         }

         public function escapeString($str) {
             return mysqli_real_escape_string($this->connect, $str);
         }

         private function error($err) {
             $err  = __CLASS__.": ".$err;
             $err .= ". Error initiated in ".$this->caller().". [".date("d.m.Y H:m:s", time())."]";
             die($err);
         }

         private function caller() {
		         $trace  = debug_backtrace();
		         $caller = '';
		         foreach ($trace as $t) {
			          if (isset($t['class']) && $t['class'] == __CLASS__) {
				            $caller = $t['file']." on line ".$t['line'];
			          } else {
				            break;
			          }
		         }
		         return $caller;
	       }
    }
