<?php
namespace Nucleus;

interface interPromocode
{
  public function __construct();
  public function getPromocode($code);
  public function activatePromocode($code, $premiumAccount, $cointPointes, $activateLimit);
}

class Promocode implements interPromocode
{
  private $db;
  private $id;

  public function __construct() {
    $this->db = DB::getInstance();
    $this->id = $_SESSION['id'];
  }

  public function getPromocode($code) {
    if (strlen($code) < 19) {
      return "1";
    }

    $code = $this->db->escapeString($code);

    $query  = "SELECT * FROM promocode WHERE promocode = '" . $code . "'";
    $result = $this->db->query($query);
    $fetch  = $this->db->fetch($result);

    if ($this->db->numRows($result) == 0) {
      return 1;
    }

    $premiumAccount = $fetch['premiumAccount'];
    $cointPointes   = $fetch['countPoints'];
    $activateLimit  = $fetch['activateLimit'];
    $blockPromocode = $fetch['blockPromocode'];

    if ($blockPromocode == 1) {
      return 2;
    }

    return $this->activatePromocode($code, $premiumAccount, $cointPointes, $activateLimit);

    $this->db->free($result);
  }

  public function activatePromocode($code, $premiumAccount, $cointPointes, $activateLimit) {
    $activateLimit_query = "SELECT COUNT(promocode) AS cnt FROM activatePromocode WHERE promocode = '" . $code . "'";
    $activateLimit_result = $this->db->query($activateLimit_query);
    $fetch = $this->db->fetch($activateLimit_result);
    if ($fetch['cnt'] != 0 && $fetch['cnt'] == $activateLimit) {
      return 2;
    }
    $this->db->free($activateLimit_result);

    $query = "SELECT * FROM activatePromocode WHERE promocode = '" . $code . "' AND user_id = $this->id";
    $result = $this->db->query($query);

    if ($this->db->numRows($result) == 0) {
      $add_activate_user = "INSERT INTO activatePromocode SET promocode = '" . $code . "', user_id = $this->id";
      $result_add = $this->db->query($add_activate_user);

      //bonus
      if ($premiumAccount != 0) {
        $premiumAccount = (int) $premiumAccount;
        $query_premium  = "UPDATE users SET premiumAccountDays = premiumAccountDays + $premiumAccount
                          WHERE id = $this->id";
        $result_bonus   = $this->db->query($query_premium);
      }

      if ($cointPointes != 0) {
        $cointPointes = (int) $cointPointes;
        $bonus_user = "UPDATE users SET rating = rating + {$cointPointes} WHERE id = {$this->id}";
        $result_bonus = $this->db->query($bonus_user);
      }

      if ($result_add && $result_bonus) {
        return 0;
      }
    } else {
      return 2;
    }
  }

}
