<?php
  require "config.php";

  use Nucleus\TPL;

  $tpl = new TPL();

  $tpl->file("about/main.TPL");

  $tpl->print_file();
  $tpl->clear();
