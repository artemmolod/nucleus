<?php 

namespace Nucleus;
require_once "scripts/TPL.php";

$tpl = new TPL();
$tpl->file("dev/main.TPL");
$tpl->parse_tpl("api_status", $api_status);
$tpl->print_file();
$tpl->clear();