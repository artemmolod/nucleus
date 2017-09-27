<?php
    require "config.php";

    use Nucleus\TPL;
    use Nucleus\Main;
    use Nucleus\Registration;
    use Nucleus\Authorization;
    use Nucleus\DB;
    use Nucleus\Upload;

    /**
    * DataBase class
    */
    $db = DB::getInstance();
    $db->query("SET NAMES utf8");

    /**
    * Registration user
    */
    $reg_email  = $_POST['reg_email'];
    $reg_pass   = $_POST['reg_pass'];
    if (isset($reg_email) && isset($reg_pass)) {
        $reg_email =  $db->escapeString($reg_email);
        $reg_pass  =  $db->escapeString($reg_pass);

        $result_reg = new Registration($reg_email, $reg_pass);
        $result_err = $result_reg->getError();

        if ($result_err == 1) echo "Err1";
        else if ($result_err == 2) echo "Err2";
        else echo 0;

        die();
        exit();
    }

    /**
    * Authorization user
    */
    $auth_email  = $_POST['auth_email'];
    $auth_pass   = $_POST['auth_pass'];
    if (isset($auth_email) && isset($auth_pass)) {
        $auth_email = $db->escapeString($auth_email);
        $auth_pass  = $db->escapeString($auth_pass);

        $auth = new Authorization();
        $result_auth = $auth->auth($auth_email, $auth_pass);
        //print $auth->getError();
        $result_err_ = $auth->getError();

        if ($result_err_ == 1) echo "Err1";
        else if ($result_err_ == 2) echo "Err2";
		else if ($result_err_ == 3) echo "Err3";
        else echo 0;

        die();
        exit();
    }

    //upload file
    $act = $_GET['act'];
    $a = $_GET['a'];
    if (!empty($act) && !empty($a)) {
       if ($a == "photo") (new Upload())->photo();
       else if ($a == "newPhoto") (new Upload())->photo(1);
       else return;
       die();
    }

    //session_destroy();

    /**
    * Init class
    */
    new Main();
