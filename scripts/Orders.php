<?php

namespace Nucleus;

interface interOrders
{
  public function __construct();
  public function duplicate($txn_id);
  public function insert($info);
}

class Orders implements interOrders
{
  private $db;

  public function __construct() {
    $this->db = DB::getInstance();
  }

  public function duplicate($txn_id) {
    $txn_id = (int) $txn_id;
    $query = "SELECT * FROM orders WHERE txn_id = $txn_id";
    $result = $this->db->query($query);
    if ($this->db->numRows($result) != 0) {
      return 1;
    } else {
      return 0;
    }
  }

  public function insert($info) {
    $query = "INSERT INTO `orders` SET
      txn_id      = '".$info["txn_id"]."',
      order_date  = '".$info['date']."',
      order_total = '".$info['total']."',
      email       = '".$info["payer_email"]."',
      first_name  = '".$this->db->escapeString($info["first_name"])."',
      last_name   = '".$this->db->escapeString($info["last_name"])."',
      street      = '".$this->db->escapeString($info["address_street"])."',
      city        = '".$this->db->escapeString($info["address_city"])."',
      state       = '".$this->db->escapeString($info["address_state"])."',
      zip         = '".$this->db->escapeString($info["address_zip"])."',
      country     = '".$this->db->escapeString($info["address_country"])."'";

    $result = $this->db->query($query);
    if ($result) return true;
    else return false;
  }

}
