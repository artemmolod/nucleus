<?php
    session_start();
    header('Content-type: text/html; charset=utf-8');
    header("X-Frame-Options:sameorigin");
    //header("Expires: ".gmdate("D, d M Y H:i:s", time()+86400*5)." GMT");
    //header("Cache-Control: private, max-age=3600");
    date_default_timezone_set('Europe/Moscow');


    //ini_set("error_reporting", -1);
    //ini_set("display_errors", 0); //1
    //ini_set("log_errors", 1);

    define("VTREKE_DIR_V1", $_SERVER['DOCUMENT_ROOT']."/scripts/");
    define("VERSION", "1.0");

    //memcache
    //$memcache = new Memcache;
    //$memcache->connect('127.0.0.1', 11211) or die ("Could not connect");

    $server_time = $_SERVER['REQUEST_TIME'];

    spl_autoload_register(function ($class)
    {
        $prefix = "Nucleus\\";
        $len = strlen($prefix);

        if (strncmp($prefix, $class, $len) !== 0) return;

        $relative_class = substr($class, $len);
        $file = VTREKE_DIR_V1 . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    });
