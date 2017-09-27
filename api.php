<?php 

$opt = [
    'host' => "mysql.hostinger.ru",
    "user" => "u116083079_targe",
    "pass" => "targets",
    "bd"   => "u116083079_targe",
    "charset" => "utf8",
];

$DB = mysqli_connect($opt['host'], $opt['user'], $opt['pass'], $opt['bd']);

if (!$DB) {
    exit(mysqli_connect_errno()." ".mysqli_connect_error());
}

mysqli_set_charset($DB, $opt['charset']);

$method = $_GET['method'];

switch ($method) {
    case "auth":
      auth($_POST['email'], $_POST['password']);
      break;

    case "reg": 
      reg($_POST['name'], $_POST['email'], $_POST['password']);
      break;

	case "addTarget":
      addTarget($_GET["target_id"], $_GET["user_id"], $_GET['name_target'], $_GET['desc_target'], $_GET['success'], $_GET['stars']);
	  break;

	case "addSteps":
      addSteps($_GET['target_id'], $_GET["step_id"], $_GET['desc'], $_GET['date'], $_GET['user_id']);
	  break;

	case "deleteAll":
      deleteAll($_POST['user_id']);
	  break;

	case "backup":
      backup($_POST['user_id']);
	  break;

	default: 
      unknownMethod();
	  break;
}

#------------------- Methods for API  -------------------- #

function auth($email, $pass) {
	$pass = hashPassword($pass);
	$select = "SELECT * FROM users WHERE email = '" . $email . "' AND password = '" . $pass . "'";
	$result = query($select);
	$numRows  = numRows($result);
	$fetch   = fetch($result);

	if ($numRows == 0) response(["error" => 2]);
	else response(["status" => 0, "response" => ["user_id" => $fetch['_id']]]);

	free($result);
}

function reg($name, $email, $pass) {
	$pass_ = hashPassword($pass);
	$select = "SELECT * FROM users WHERE email = '" . $email . "' AND password = '" . $pass_ . "'";
	$result = query($select);
	$numRows  = numRows($result);

	if ($numRows != 0) response(["error" => 1]);
	else {
		$authQuery = "INSERT INTO users SET name = '" . $name . "',
		              email = '" . $email . "', password = '" . $pass_ . "'";
		$result = query($authQuery);

		auth($email, $pass);
	}
}

function deleteAll($user_id) {
    $queryDeleteTargets = "DELETE FROM target WHERE user_id = $user_id";
    $queryDeleteSteps = "DELETE FROM steps WHERE user_id = $user_id";

    query($queryDeleteTargets);
    query($queryDeleteSteps);
}

function backup($uid) {
	$response = [];
	$response['status'] = 0;
	$response['targets'] = [];
	$response['steps'] = [];

	$selectAllTargets = "SELECT * FROM target WHERE user_id = $uid";
	$resultSelect = query($selectAllTargets);
    while ($row = fetch($resultSelect)) {
    	$result = [];
    	$result['name_target'] = $row['name'];
    	$result['desc_target'] = $row['desc'];
    	$result['success'] = $row['success'];
    	$result['stars'] = $row['stars'];
    	array_push($response['targets'], $result);
    }

    $selectAllSteps = "SELECT * FROM steps WHERE user_id = $uid";
	$resultSelect = query($selectAllSteps);
    while ($row = fetch($resultSelect)) {
    	$result = [];
    	$result['name_target'] = $row['name_target'];
    	$result['text_step'] = $row['text_step'];
    	$result['date'] = $row['date_'];
    	array_push($response['steps'], $result);
    }

    response($response);
}

function addTarget($target_id, $user_id, $name, $desc, $success, $stars) {
	$select = "SELECT * FROM target WHERE target_id = $target_id AND user_id = $user_id";
	$result = query($select);
    if (numRows($result) != 0) {
    	query("DELETE FROM target WHERE target_id = $target_id AND user_id = $user_id");
    }

    $query = "INSERT INTO `target`(`target_id`, `user_id`, `name`, `desc`, `success`, `stars`) VALUES (
              {$target_id}, {$user_id}, '".$name."', '".$desc."', '".$success."', {$stars})";

    $result = query($query) or die(mysqli_error());

    if ($result) response(["status" => 0]);
    else response(["error" => 1]);
}

function addSteps($target_id, $step_id, $desc, $date, $user_id) {
	$select = "SELECT * FROM steps WHERE step_id = $step_id AND name_target = '".$target_id."' AND text_step = '".$desc."'";
	$result = query($select);
    if (numRows($result) != 0) {
    	response(["status" => 0]);
    	return;
    }

	$query = "INSERT INTO steps SET step_id = $step_id, name_target = '".$target_id."', text_step = '" . $desc . "',
              date_ = '" . $date . "', user_id = $user_id";

    $result = query($query);

    if ($result) response(["status" => 0]);
    else response(["error" => 1]);
}

function unknownMethod() {
  header("Content-Type: application/json; charset=utf-8");
  print json_encode(["error" => "Unknown method"]);
}

function response($res) {
	header("Content-Type: application/json; charset=utf-8");
    print json_encode($res, JSON_UNESCAPED_UNICODE);
}

function hashPassword($pass) {
	return md5($pass);
}


#----------- Methods for work with database  -------------- #

function query($query) {
	global $DB;
	return $res = mysqli_query($DB, $query);
}

function fetch($res) {
	return mysqli_fetch_array($res, MYSQLI_BOTH);
}

function free($res) {
    return mysqli_free_result($res);
}

function escapeString($str) {
	global $DB;
    return mysqli_real_escape_string($DB, $str);
}

function numRows($res) {
    return mysqli_num_rows($res);
}