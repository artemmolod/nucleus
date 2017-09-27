<?php
   namespace Nucleus;

   class Vote
   {
      public $id;
      private $db;
      private $tpl;
      public $id_post;

      public function __construct($id_post) {
          $this->id = $_SESSION['id'];
          $this->db = DB::getInstance();
          $this->id_post = $id_post;
          $this->tpl = new TPL();
      }

      public function init() {
         $query_select_uid = "SELECT uid FROM album WHERE id = $this->id_post";
         $result_query = $this->db->query($query_select_uid);
         $fetch_uid = $this->db->fetch($result_query);

         if ($fetch_uid['uid'] == $this->id) {
             die("1");
             exit();
         }

         $this->db->free($result_query);

         $this->tpl->file("vote/main.TPL");
         $this->tpl->parse_tpl("{idp}", $this->id_post);
         $this->tpl->print_file();
      }
   }
