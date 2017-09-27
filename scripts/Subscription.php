<?php
    namespace Nucleus;

    class Subscription
    {
        private $db;
        private $id;
        private $tpl;
        private $result_query;

        private $friends = false;

        public function __construct($uid, $friends = false) {
            $this->db = DB::getInstance();
            $this->id = $uid;
            $this->tpl = new TPL();
            $this->friends = $friends;
        }

        public function getNum() {
            if (!$this->friends) {
              $query_get_num = "SELECT * FROM friends WHERE fid = $this->id";
            } else {
              $query_get_num = "SELECT * FROM friends WHERE uid = $this->id";
            }
            $result_get_num = $this->db->query($query_get_num);
            $this->result_query = $result_get_num;

            return $this->db->numRows($result_get_num);
        }

        public function getLoadQuery() {
            return $this->result_query;
        }
    }
