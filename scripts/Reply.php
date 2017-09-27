<?php

namespace Nucleus;

interface ReplyInterface
{
  public function __construct();
  public function getNumReply();
  public function printReply();
  public function getResultReply();
  public function updateReadNotify($notify_id);
}

class Reply implements ReplyInterface
{
  private $id;
  private $db;
  private $tpl;

  private $result;

  public function __construct() {
    $this->db = DB::getInstance();
    $this->id = $_SESSION["id"];
  }

  public function getNumReply() {
    if (!$this->id) return;

    $query_num_reply = "SELECT * FROM notify WHERE (nid = $this->id OR nid = 0) AND date_ + 60 * 60 * 24 * 10 >= '" . time() . "' ORDER BY date_ DESC";
    $result_query = $this->db->query($query_num_reply);
    $numRows = $this->db->numRows($result_query);

    if ($numRows != 0) $this->result = $result_query;

    return $numRows;
  }

  public function printReply() {
    $this->tpl->file("reply/main.TPL");
    $this->tpl->print_file();
    $this->tpl->clear();
  }

  public function getResultReply() {
    return $this->result;
  }

  public function updateReadNotify($notify_id) {
    $notify_id = (int) $notify_id;
    $update_read_query = "UPDATE notify SET read_ = 1 WHERE id = $notify_id";
    $result_update = $this->db->query($update_read_query);
  }
}
