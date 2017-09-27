<?php
    namespace Nucleus;

    class Lenta
    {
        private $db;
        private $tpl;
        public $id;

        public function __construct() {
            $this->db = DB::getInstance();
            $this->id = $_SESSION['id'];
        }

        public function loadLenta($cnt) {}

        public function getLentaNumRows() {
            $query_select_num_rows  = "SELECT * FROM friends WHERE fid = $this->id AND friends = 1";
            $result_select_num_rows = $this->db->query($query_select_num_rows);
            $num_rows = $this->db->numRows($result_select_num_rows);

            if ($num_rows == 0) return false;
            else return true;

            return false;
        }
    }
