<?php
require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

use Nucleus\DB;

$db = DB::getInstance();

$query = "SELECT id FROM users WHERE premiumAccountDays > 0";
$result = $db->query($query);
while ($row = $db->fetch($result)) {
  $query_ = "UPDATE users SET premiumAccountDays = premiumAccountDays - 1 WHERE id = {$row['id']}";
  $db->query($query_);
}
$db->free($result);
