<?php

header('Content-type: application/json; charset=utf-8');

require_once "system/DB.php";
require_once "system/APIconfig.php";

interface interMethod
{
  public function __construct();
  public function users($type, $user_ids, $fields);
  public function photo($type, $user_ids, $flag, $vote = false, $secret_key);
  public function subscription($type, $user_id);
  public function account($type, $user_id);
  public function competition($type);
  public function query($query);
  public function error($code);
  public function secret_key($secret_key);
  public function execute();
  public function hashPassword($pass);
}

class Method implements interMethod
{
  /**
  * @param $db;
  */
  private $db;

  /**
  * @param $result;
  */
  private $result;

  /**
  * @param $response;
  */
  private $response;

  public function __construct() {
    if (API_CLOSE == 1) {
      $error = $this->error(14);
      throw new Exception($error);
    }
    $this->db = DB::getInstance();
  }

  public function users($type, $user_ids, $fields) {
    switch ($type) {
      case "get":
        $fields  = $this->db->escapeString($fields);
        $ids_arr = explode(",", $user_ids);
        $ids_cnt = count($ids_arr);
        if ($ids_cnt == 1) {
          $user_ids = (int) $user_ids;
          $query  = "SELECT {$fields} FROM users WHERE id = $user_ids";
          $result = $this->query($query);
          if ($result == -1) {
            $result_arr = [
              "id" => $user_ids,
              "status" => "User not found"
            ];
            $this->result = $result_arr;
          } else {
            $fields_explode = explode(",", $fields);
            if (count($fields_explode) != 0 and $fields_explode[0] != null) {
              $result_arr = [
                "id" => $user_ids
              ];
              foreach($fields_explode as $field) {
                $field = trim($field);
                if ($field == "email" || $field == "password") continue;
                $result_arr[$field] = $result[$field];
              }
            }
            $this->result = $result_arr;
          }
        } else {
          $response_ = [];
          $response_["count"] = $ids_cnt;
          $response_['result'] = [];
          for ($i = 0; $i < $ids_cnt; $i++) {
            $u_ids = (int) $ids_arr[$i];
            $query_ = "SELECT {$fields} FROM users WHERE id = $u_ids";
            $result = $this->query($query_);
            if ($result == -1) {
              $result_arr = [
                "id" => $u_ids,
                "status" => "User not found"
              ];
              array_push($response_['result'], $result_arr);
              continue;
            }
            $fields_explode = explode(",", $fields);
            if (count($fields_explode) != 0 and $fields_explode[0] != null) {
              $result_arr = [
                "id" => $u_ids
              ];
              foreach($fields_explode as $field) {
                $field = trim($field);
                if ($field == "email" || $field == "password") continue;
                $result_arr[$field] = $result[$field];
              }
              array_push($response_['result'], $result_arr);
            }
          }
          $this->result = $response_;
        }
        $this->execute();
        break;

      case "search":
        $ids_arr = explode(",", $user_ids);
        $ids_cnt = count($ids_arr);
        $response_ = [];
        $response_["count"] = $ids_cnt;
        $response_['result'] = [];
        for ($i = 0; $i < $ids_cnt; $i++) {
          $u_ids = (int) $ids_arr[$i];
          $query_ = "SELECT first_name FROM users WHERE id = $u_ids";
          $result = $this->query($query_);
          if ($result == -1) {
            $result_arr = [
              "id" => $u_ids,
              "status" => 1
            ];
          } else {
            $result_arr = [
              "id" => $u_ids,
              "status" => 0
            ];
          }
          array_push($response_['result'], $result_arr);
        }
        $this->result = $response_;
        $this->execute();
        break;

      default:
        $this->error(12);
        break;
    }
  }

  public function photo($type, $user_ids, $flag, $vote = false, $secret_key) {
    $flag  = $this->db->escapeString($flag);
    $ids_arr = explode(",", $user_ids);
    $ids_cnt = count($ids_arr);
    $response_ = [];
    $response_["count"] = $ids_cnt;
    $response_['result'] = [];

    switch ($type) {
      case "get":
        for ($i = 0; $i < $ids_cnt; $i++) {
          $uid = (int) $ids_arr[$i];
          $query = "SELECT id, src, title, descr, category, time_, rating FROM album
                    WHERE uid = $uid AND upload = 0 AND del = 0
                    ORDER BY {$flag} DESC";
          $result = $this->db->query($query);
          $numRows = $this->db->numRows($result);
          if ($numRows == 0) continue;
          $result_arr["user_id"] = $uid;
          $result_arr['count']   = $numRows;
          $result_arr['list']    = [];
          while ($row = $this->db->fetch($result)) {
            $result_arr_ = [
              "photo_id"       => $row['id'],
              "photo_src"      => "http://web-nucleus.com" . $row['src'],
              "photo_title"    => $row['title'],
              "photo_descr"    => $row['descr'],
              "photo_category" => $row['category'],
              "photo_time"     => $row['time_'],
              "photo_rating"   => $row['rating'],
            ];
            array_push($result_arr['list'], $result_arr_);
          }
          array_push($response_['result'], $result_arr);
          $this->db->free($result);
        }
        break;

      case "voteFor":
        if (empty($secret_key)) {
          $this->error(4);
          return;
        } else {
          $correct_secret_key = $this->secret_key($secret_key);
          if (!$correct_secret_key) {
            $this->error(6);
            return;
          }
        }
        if (empty($vote) || empty($user_ids)) {
          $this->error(5);
          return;
        }
        $photo_id = $user_ids;
        $query = "UPDATE album SET rating = rating + $vote WHERE id = $photo_id";
        $result = $this->db->query($query);
        if ($result) {
          $response_ = [
            "status" => 0,
          ];
        } else {
          $response_ = [
            "status" => 1,
          ];
        }
        break;

      case "voteNegative":
        if (empty($secret_key)) {
          $this->error(4);
          return;
        } else {
          $correct_secret_key = $this->secret_key($secret_key);
          if (!$correct_secret_key) {
            $this->error(6);
            return;
          }
        }
        if (empty($vote) || empty($user_ids)) {
          $this->error(5);
          return;
        }
        $photo_id = $user_ids;
        $query_select = "SELECT rating FROM album WHERE id = $photo_id";
        $result_query = $this->db->query($query_select);
        $fetch_ = $this->db->fetch($result_query);
        if ($fetch_['rating'] - $vote <= 0) {
          $query = "UPDATE album SET rating = 0 WHERE id = $photo_id";
        } else {
          $query = "UPDATE album SET rating = rating - $vote WHERE id = $photo_id";
        }
        $this->db->free($result_query);
        $result = $this->db->query($query);
        if ($result) {
          $response_ = [
            "status" => 0,
          ];
        } else {
          $response_ = [
            "status" => 1,
          ];
        }
        break;

      default:
        $this->error(12);
        break;
    }
    $this->result = $response_;
    $this->execute();
  }

  public function subscription($type, $user_id) {
    $start = microtime(true);
    switch ($type) {
      case "get":
        $query  = "SELECT * FROM friends WHERE uid = $user_id";
        $result = $this->db->query($query);
        if ($this->db->numRows($result) == 0) {
          $result_arr = [
            "id" => $user_ids,
            "status" => "User not found"
          ];
        } else {
          $result_arr = [
            "count" => $this->db->numRows($result),
          ];
          $result_arr['item'] = [];
          while ($row = $this->db->fetch($result)) {
            $result_ = [
              "fid" => $row['fid'],
              "friends" => $row['friends'],
            ];
            array_push($result_arr['item'], $result_);
          }
        }
        $this->result = $result_arr;
        $this->execute();
        break;

      default:$this->error(12);break;
    }
    $end = microtime(true);
    //print $time = ($end - $start) * 1000;
  }

  public function account($type, $user_id) {}

  public function competition($type) {
    $start = microtime(true);
    switch ($type) {
      case "get":
        $query = "SELECT * FROM competition WHERE end_ = 0";
        $result = $this->db->query($query);
        $fetch = $this->db->fetch($result);
        $result_arr = [
          "date_start" => $fetch['dateStart'],
          "date_end"   => $fetch['dateEnd'],
        ];
        $this->result = $result_arr;
        $this->db->free($result);
        $this->execute();
        break;

      case "oldResult":
        $query = "SELECT * FROM competition WHERE end_ = 1 ORDER BY dateEnd DESC LIMIT 1";
        $result = $this->db->query($query);
        $fetch = $this->db->fetch($result);
        $result_arr = [
          "winner_id"          => $fetch['wid'],
          "winner_two_id"      => $fetch['placeTwo'],
          "winner_three_id"    => $fetch['placeThree'],
          "winner_photo_one"   => $fetch["photoOne"],
          "winner_photo_two"   => $fetch["photoTwo"],
          "winner_photo_three" => $fetch["photoThree"],
          "date_start"         => $fetch['dateStart'],
          "date_end"           => $fetch['dateEnd'],
        ];
        $this->result = $result_arr;
        $this->db->free($result);
        $this->execute();
        break;

      default: $this->error(12); break;
    }
    $end = microtime(true);
    //print $time = ($end - $start) * 1000;
  }

  public function auth() {
    $email = $this->db->escapeString($_POST['email']);
    $password = $this->db->escapeString($_POST['password']);
    $secret_key = $this->db->escapeString($_POST['secret_key']);

    $access = $this->secret_key($secret_key);
    if (!$access) {
      $this->error(8);
      return;
    }

    $h_password = $this->hashPassword($password);
    $query = "SELECT id, first_name, last_name FROM users WHERE email = '" . $email . "' AND password = '" . $h_password . "'";
    $result_ = $this->db->query($query);
    if ($this->db->numRows($result_)) {
      $this->error(18);
      return;
    }
    $fetch = $this->db->fetch($result_);
    $this->result = [
      "status" => "OK",
      "fields" => [
        "user_id" => $fetch['id'],
        "first_name" => $fetch['first_name'],
        "last_name" => $fetch['last_name']
      ]
    ];
    $this->execute();
    $this->db->free();
  }

  public function hashPassword ($p) {
    $p = md5($p);
    for ($i = 0; $i < 5; $i++) {
        $p .= md5($p.$i);
    }
    $p = hash("sha256", $p);
    $p = md5($p);
    return $p;
  }

  public function secret_key($secret_key) {
    $APIkey = [
      "sDFi0v8933JbjDd2",
      "d4Hu888sbH98sjG2",
      "hhf8fst234nHFTjn",
      "gt2bhbf4531mnHHs",
    ];
    if (!in_array($secret_key, $APIkey)) {
      return false;
    } else {
      return true;
    }
  }

  public function query($query) {
    $result = $this->db->query($query);
    if ($this->db->numRows($result) == 0) {
      return -1;
    }
    $fetch_info = $this->db->fetch($result);
    $this->db->free($result);

    return $fetch_info;
  }

  public function error($code) {
    switch ($code) {
      case 18: $err_msg = "User not found"; break;
      case 14: $err_msg = "Api closed"; break;
      case 12: $err_msg = "Unknown method"; break;
      case 11: $err_msg = "Incorrect parameter type"; break;
      case  8: $err_msg = "Authorisation Error"; break;
      case  6: $err_msg = "Invalid secret key"; break;
      case  5: $err_msg = "Parameter not found"; break;
      case  4: $err_msg = "This method requires a secret key"; break;
    }
    $error = [
      "error" => [
        "code"    => $code,
        "message" => $err_msg
      ]
    ];
    print json_encode($error);
  }

  public function execute() {
    $this->response["response"] = [];
    array_push($this->response["response"], $this->result);
    print json_encode($this->response, JSON_UNESCAPED_UNICODE);
  }

}

///////////////////////////////////////////////////
/////
/////   Work API
/////
///////////////////////////////////////////////////

$query_string    = $_SERVER['QUERY_STRING'];
$method_api      = explode("&", $query_string);
$method_api_name = explode(".", $method_api[0]);
$type            = $method_api_name[1];

try {
  $method = new Method();

  switch ($method_api_name[0]) {
    case "users":
      $fields = !empty($_GET['fields']) ? $_GET['fields'] : "first_name, last_name, sex, bdate";
      $user_ids = $_GET['user_ids'];
      if (empty($user_ids)) {
        $method->error(5);
        return;
      }
      $method->users($type, $user_ids, $fields);
      break;

    case "photo":
      $flag = !empty($_GET['flag']) ? $_GET['flag'] : "rating";
      $secret_key = $_GET['secret_key'];
      if ($type == "get") {
        $user_ids = $_GET['user_ids'];
        if (empty($user_ids)) {
          $method->error(5);
          return;
        }
        $method->photo($type, $user_ids, $flag, false, $secret_key);
      } else if ($type == "voteFor" || $type == "voteNegative") {
        $vote = (int) $_GET["vote"];
        $photo_id = $_GET['photo_id'];
        if (empty($photo_id) || empty($vote)) {
          $method->error(5);
          return;
        }
        $method->photo($type, $photo_id, false, $vote, $secret_key);
      } else {
        $method->error(12);
      }
      break;

    case "subscription":
      $user_id = (int) $_GET['user_id'];
      if (empty($user_id)) {
        $method->error(5);
        return;
      }
      if ($type == "get") {
        $method->subscription($type, $user_id);
      } else {
        $method->error(12);
      }
      break;

    case "competition":
      $method->competition($type);
      break;

    case "auth":
      $method->auth();
      break;

    default:
      $method->error(12);
      break;
  }

} catch (Exception $e) {
  print $e->getMessage();
}
