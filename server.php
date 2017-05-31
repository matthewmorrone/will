<?php
if ($_POST) {
	extract($_POST);


	$credentials = array_map(function($a) {
		return trim($a);
	}, file('credentials.txt'));

    $address  = (isset($address)  ? $address  : $credentials[0]);
    $username = (isset($username) ? $username : $credentials[1]);
    $password = (isset($password) ? $password : $credentials[2]);
    // $connect = connect($server, $username, $password);
	// $link = connect($account, $username, $password, $database) or die(mysqli_error($link));

    $database = (isset($database) ? $database : $credentials[3]);
    // $database = database($database, $connect);
	// $database 	= (isset($database) 	? $database 	: "");



	switch($mode) {
		case "all":
			$mysqli = connect($address, $username, $password, $database);
			$query = 'SELECT id, created, title, blurb, image FROM posts ORDER BY created';
			echo json_query($mysqli, $query);
		break;
		case "get":
			$mysqli = connect($address, $username, $password, $database);
			$id = (int)$id;
			if (is_int($id)) {
				$query = "SELECT id, created, modified, title, blurb, content, image FROM posts WHERE id = $id";
				echo json_encode(get_query($mysqli, $query)[0][0]);
			}
		break;
		case "auth":
			if (strcmp($password, 'will') === 0) {
				echo 'win';
			}
			else {
				echo 'fail';
			}
		break;
		case "new":
			$mysqli = connect($address, $username, $password, $database);
			$title = mysql_real_escape_string($title);
			$blurb = mysql_real_escape_string($blurb);
			$content = mysql_real_escape_string($content);
			$query = "INSERT INTO posts (title, blurb, content) VALUES ('$title', '$blurb', '$content')";
			$result = $mysqli->query($query);
			// echo $mysqli->error."\n";
		break;
		case "edit":
			$mysqli = connect($address, $username, $password, $database);
			$title = mysql_real_escape_string($title);
			$blurb = mysql_real_escape_string($blurb);
			$content = mysql_real_escape_string($content);
			$query = "UPDATE posts SET title = '$title', blurb = '$blurb', content = '$content'";
			$result = $mysqli->query($query);
			// echo $mysqli->error."\n";
		break;
		case "delete":
			$mysqli = connect($address, $username, $password, $database);
			$query = "DELETE FROM posts WHERE id = $id";
			$result = $mysqli->query($query);
			// echo $mysqli->error."\n";
		break;
		default:
			echo "fail\n";
		break;
	}



	if (isset($mysqli)) {
		mysqli_close($mysqli);

	}
}

function connect($address, $username, $password, $database) {
	$mysqli = new mysqli($address, $username, $password, $database);
	return $mysqli;
}
function pluck($array, $i = 0) {
	$array2 = [];
	foreach($array as $key=>$val) {
		$array2[] = $val[$i];
	}
	return $array2;
}
function json_query($link, $query) {
	return json_encode(get_query($link, $query));
}
function get_query($link, $query) {
	trim($query);
	$result = $link->query($query);
	$num_rows = $result->num_rows;
	for($i = 0; $i < $num_rows; $i++):
		$res[$i][] = $result->fetch_assoc();
	endfor;
	return $res;
}
function print_query($link, $query) {
	trim($query);
	$result = $link->query($query);
	$num_rows = $result->num_rows;
	$fields = $result->fetch_fields();
	echo "<table>";
	for($i = 0; $i < $num_rows; $i++):
		$row = $result->fetch_assoc();
		if ($i == 0):
			echo "<tr>";
			foreach($row as $field=>$cell):
				echo "<th>".$field."</th>";
			endforeach;
			echo "</tr>";
		endif;
		echo "<tr>";
		foreach($row as $field=>$cell):
			echo "<td>".$cell."</td>";
		endforeach;
		echo "</tr>";
	endfor;
	echo "</table>";
}

?>
