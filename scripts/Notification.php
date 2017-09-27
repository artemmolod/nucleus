<?php

namespace Nucleus;

interface NotificationInterface
{
  public function __construct();
  public function create($type, ...$params);
}

class Notification implements NotificationInterface
{
  private $db;
  public $id;

  public function __construct() {
    $this->db = DB::getInstance();
    $this->id = $_SESSION['id'];
  }

  /**
  * Create alert for user about an event
  *
  * @param type : 0 - vote for (int num of votes); 1 - negative vote (int num of votes); 2 - friends request; 3 - added new comment
  * 4 - winner competition id, 5 - place second competition, 6 - place third competition
  * @param params: list of parameter (Type: String, Int, etc)
  *
  * @return boolean result
  */
  public function create($type, ...$params) {
    if (!$this->id) return -1;

    $date = time();
    switch ($type) {
      case 0:
        $query_notification = "INSERT INTO `notify` (`type`, `nid`, `uid`, `rating`, `post_photo`, `date_`)
                               VALUES ($type, '" . $params[1] . "', '" . $this->id . "', '" . $params[0] . "', '" . $params[2] . "', $date)";
        break;

      case 1:
        $query_notification = "INSERT INTO `notify` (`type`, `nid`, `uid`, `rating`, `post_photo`, `date_`)
                               VALUES ($type, '" . $params[1] . "', '" . $this->id . "', '" . $params[0] . "', '" . $params[2] . "', $date)";
        break;

      case 2:
        $query_notification = "INSERT INTO `notify` (`type`, `nid`, `uid`, `date_`)
                               VALUES ($type, $params[0], $this->id, $date)";
        break;

      case 3:
        $query_notification = "INSERT INTO `notify` (`type`, `nid`, `uid`, `post_photo`, `post_comment`, `date_`)
                               VALUES ($type, $params[0], $this->id, $params[1], '" . $params[2] . "', $date)";
        break;

      case 4:
        $competition_comment = "Награда: +1000 баллов к рейтингу, статус короля.";
        $query_notification = "INSERT INTO `notify` (`type`, `nid`, `post_comment`, `date_`)
                               VALUES ($type, $params[0], '" . $competition_comment . "', $date)";
        break;

      case 5:
        $competition_comment = "Награда: +500 баллов к рейтингу.";
        $query_notification = "INSERT INTO `notify` (`type`, `nid`, `post_comment`, `date_`)
                               VALUES ($type, $params[0], '" . $competition_comment . "', $date)";
        break;

      case 6:
        $competition_comment = "Награда: +250 баллов к рейтингу.";
        $query_notification = "INSERT INTO `notify` (`type`, `nid`, `post_comment`, `date_`)
                               VALUES ($type, $params[0], '" . $competition_comment . "', $date)";
        break;

      default:
        break;
    }

    $result_query = $this->db->query($query_notification);
    if ($result_query) {
      return 0;
    } else {
      return 1;
    }

  }
}
