<?php
namespace Nucleus;

interface interSearch
{
  public function __construct();
  public function q($s);
}

class Search implements interSearch
{
  private $id;
  private $db;
  private $tpl;

  private $cnt_result_search;

  public function __construct() {
    $this->id = $_SESSION['id'];
    $this->db = DB::getInstance();
    $this->tpl = new TPL();
  }

  public function q($s) {
    if (!$this->id) return false;

    $s = urldecode($s);
    $escape_s = $this->db->escapeString($s);
    $split_q = explode(" ", $escape_s);

    if (count($split_q) == 1) {
      $query_search = "SELECT id, first_name, last_name, photo_src, rating FROM users WHERE
                       first_name = '" . $split_q[0] . "' OR last_name = '" . $split_q[0] . "' ORDER BY rating DESC";
    } else {
      $query_search = "SELECT id, first_name, last_name, photo_src, rating FROM users WHERE
                      (first_name = '" . $split_q[0] . "' AND last_name = '" . $split_q[1] . "') OR
                      (first_name = '" . $split_q[1] . "' AND last_name = '" . $split_q[0] . "') ORDER BY rating DESC";
    }

    $result_query_search = $this->db->query($query_search);
    $this->cnt_result_search = $this->db->numRows($result_query_search);

    if ($this->cnt_result_search != 0) {
      $this->tpl->file("search/container.TPL");

      while ($row = $this->db->fetch($result_query_search)) {

        $name = $row['first_name'] . " " . $row['last_name'];
        if ($row['photo_src'] != "") {
          $photo_src = "/upload/" . $row['id'] . "/photo/photo-profile.jpg";
        } else {
          $photo_src = "/tpl/img/no-photo-profile.png";
        }

        $this->tpl->template("search/list.TPL");
        $this->tpl->parse_tpl("{name}", $name, true);
        $this->tpl->parse_tpl("{uid}", $row['id'], true);
        $this->tpl->parse_tpl("{photo_src}", $photo_src, true);
        $this->tpl->parse_tpl("{rating}", $rating, true);
        $this->tpl->complete("list_search");
      }
      $this->tpl->parse_tpl("{cnt_result_search}", $this->cnt_result_search);
      $this->tpl->parse_tpl("{list_search}", "");
      $this->tpl->print_file();
    } else {
      $this->tpl->file("search/no-result.TPL");
      $this->tpl->parse_tpl("{query}", $s);
      $this->tpl->print_file();
    }
    $this->db->free($result_query_search);
    exit();
  }
}
