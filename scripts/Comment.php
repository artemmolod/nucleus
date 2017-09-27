<?php

namespace Nucleus;

class Comment
{
    public $id;
    private $db;
    private $tpl;
    public $post_id;
    private $result;
    public $king;

    public function __construct($post_id, $king_status) {
        $this->id = $_SESSION['id'];
        $this->db = DB::getInstance();
        $this->tpl = new TPL();
        $this->post_id = $post_id;
        $this->king = $king_status;
    }

    public function query() {
        $comment_query = "SELECT * FROM comment_photo_album WHERE post_id = $this->post_id ORDER BY date_ DESC";
        $result_comment = $this->db->query($comment_query);
        $this->result = $result_comment;

        return $this->result;
    }

    public function init() {
        $this->tpl->file("comment/main.TPL");

        $query = $this->query();
        $numRows = $this->db->numRows($query);

        if ($numRows == 0) {
           $this->tpl->template("comment/no.TPL");
           $this->tpl->complete("comment-content");
        } else {
           while ($row = $this->db->fetch($query)) {
              $query_info_user = "SELECT first_name, last_name FROM users WHERE id = {$row['uid']}";
              $result_info = $this->db->query($query_info_user);
              $fetch_info = $this->db->fetch($result_info);

              //parse info
              if ($this->king == 1) {
                $name = $fetch_info['first_name'] . " " . $fetch_info['last_name'];
                $image = "/upload/" . $row['uid'] . "/photo/icon-profile.jpg";
                $user_id = $row['uid'];
              } else {
                $name = "Засекречено";
                $image = "/tpl/img/no-photo-profile.png";
                $user_id = 0;
              }
              $text  = $row['msg'];
              $date  = date("d.m.Y", $row['date_']);
              $time  = date("H:m", $row['date_']);
              $datetime = $date . " in " . $time;

              $this->tpl->template("comment/list.TPL");
              $this->tpl->parse_tpl("{name}", $name, true);
              $this->tpl->parse_tpl("{uid}", $user_id, true);
              $this->tpl->parse_tpl("{image}", $image, true);
              $this->tpl->parse_tpl("{text}", $text, true);
              $this->tpl->parse_tpl("{date}", $datetime, true);
              $this->tpl->complete("comment-content");

              $this->db->free($result_info);
           }
        }

        $this->tpl->parse_tpl("{cnt-comment}", $numRows);
        $this->tpl->parse_tpl("{comment-content}", "");
        $this->tpl->print_file();
        $this->db->free($this->result);
    }
}
