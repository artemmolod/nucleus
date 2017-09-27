<?php

namespace Nucleus;

interface competitionInterface
{
  public function __construct();
  public function competitionStart();
  public function competitionEnd();
  public function getCompetitionStatus();
  public function getCompetitionTop();
  public function getCompetitionWinner();
  public function getCompetitionWinnerOld();
}

class Competition implements competitionInterface
{
  private $db;
  private $winner;

  public function __construct() {
    $this->db = DB::getInstance();
  }

  /**
  * competition new start
  */
  public function competitionStart() {
    $dateStart = time();
    $dateEnd   = $dateStart + 60 * 60 * 24 * 7;
    $query_add_competition = "INSERT INTO `competition`(`dateStart`, `dateEnd`)
                              VALUES ('{$dateStart}', '{$dateEnd}')";
    $result_add_competition = $this->db->query($query_add_competition);
  }

  /**
  * competition end
  */
  public function competitionEnd() {
    //update king of the site
    $update_status_king = "UPDATE users SET king = 0 WHERE king = 1";
    $result_upd_status_king = $this->db->query($update_status_king);

    $select_photo_winn = "SELECT * FROM album, competition
                          WHERE album.time_ >= competition.dateStart AND album.time_ <= competition.dateEnd AND competition.end_ = 0
                          ORDER BY album.rating DESC LIMIT 3";
    $result_select_photo_winner = $this->db->query($select_photo_winn);
    $winner_users = [];
    while ($row = $this->db->fetch($result_select_photo_winner)) {
      $arr = [
        'uid'   => $row['uid'],
        'photo' => $row['src'],
      ];
      array_push($winner_users, $arr);
    }
    $this->winner = $winner_users;
    $this->db->free($result_select_photo_winner);

    $winner_id = (int) $this->winner[0]['uid'];
    $two_id    = (int) $this->winner[1]['uid'];
    $three_id  = (int) $this->winner[2]['uid'];
    $photo_one = $this->winner[0]['photo'];
    $photo_two = $this->winner[1]['photo'];
    $photo_thr = $this->winner[2]['photo'];

    $query_end = "UPDATE competition SET
                  wid = $winner_id, placeTwo = $two_id, placeThree = $three_id,
                  photoOne = '" . $photo_one . "', photoTwo = '" . $photo_two . "', photoThree = '" . $photo_thr . "',
                  end_ = 1 WHERE end_ = 0";
    $result_end_competition = $this->db->query($query_end);
  }

  /**
  * @return status
  */
  public function getCompetitionStatus() {
    $status_query = "SELECT * FROM competition WHERE end_ = 0";
    $result_query_status = $this->db->query($status_query);
    if ($this->db->numRows($result_query_status) == 0) {
      return -1;
    } else {
      $fetch_status = $this->db->fetch($result_query_status);
      return [
        "dateStart" => $fetch_status['dateStart'],
        "dateEnd"   => $fetch_status['dateEnd'],
      ];
    }
    $this->db->free($result_query_status);
  }

  /**
  * @return top photo else -1
  */
  public function getCompetitionTop() {
    $select_photo_winn = "SELECT album.id as album_id, album.uid, album.src, album.time_, album.title, album.descr, album.upload, album.del
                          FROM album, competition
                          WHERE album.del = 0 AND album.upload = 0 AND album.time_ >= competition.dateStart AND album.time_ <= competition.dateEnd AND competition.end_ = 0
                          ORDER BY album.rating DESC LIMIT 3";
    $result_select_photo_winner = $this->db->query($select_photo_winn);

    if ($this->db->numRows($result_select_photo_winner) == 0) {
      return -1;
    }

    $top_users = [];
    while ($row = $this->db->fetch($result_select_photo_winner)) {
      $arr = [
        'photo_id' => $row['album_id'],
        'user_id'  => $row['uid'],
        'photo'    => $row['src'],
        'time'     => $row['time_'],
        'title'    => $row['title'],
        'descr'    => $row['descr']
      ];
      array_push($top_users, $arr);
    }

    return $top_users;
  }

  /**
  * @return array winners
  */
  public function getCompetitionWinner() {
    return $this->winner;
  }

  /**
  * @return winner of the competition old
  */
  public function getCompetitionWinnerOld() {
    $query = "SELECT * FROM competition WHERE end_ = 1 ORDER BY dateEnd DESC LIMIT 1";
    $resutlt_winner_old = $this->db->query($query);
    if ($this->db->numRows($resutlt_winner_old) == 0) {
      return -1;
    } else {
      return $this->db->fetch($resutlt_winner_old);
    }
    $this->db->free($resutlt_winner_old);
  }

}
