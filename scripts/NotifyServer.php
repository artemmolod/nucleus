<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

use Nucleus\DB;

$db = DB::getInstance();
$id = $_SESSION['id'];

if (!$id) return;

$find_mess = $db->query("SELECT * FROM notify WHERE nid = $id AND read_ = 0");
if ($db->numRows($find_mess) != 0) die("1");
else die("0");
