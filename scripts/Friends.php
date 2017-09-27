<?php
    namespace Nucleus;

    class Friends
    {
        private $db;
        public $id;

        public function __construct() {
            $this->db = DB::getInstance();
            $this->id = $_SESSION['id'];
        }

        public function add($uid) {
            $query_add_friend = "INSERT INTO `friends`(`uid`, `fid`, `friends`) VALUES($uid, $this->id, 1)";
            $result_add_req = $this->db->query($query_add_friend);

            if ($result_add_req) {
              $notify = new Notification();
              $notify->create(2, $uid);
              die("0");
            } else  die("1");

            exit();
        }

        public function del($uid) {
            $query_delete_friends = "DELETE FROM friends WHERE fid = $this->id AND uid = $uid";
            $result_delete_req = $this->db->query($query_delete_friends);

            if ($result_delete_req) die("0");
            else die("1");

            exit();
        }
    }
