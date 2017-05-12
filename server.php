<?php
if ($_POST) {
	extract($_POST);




    $server = (isset($server) ? $server : "localhost");
    $address = (isset($address) ? $address : "localhost");
    $username = (isset($username) ? $username : "root");
    $password = (isset($password) ? $password : "root");
    // $connect = connect($server, $username, $password);
	// $link = connect($account, $username, $password, $database) or die(mysqli_error($link));

    $database = (isset($database) ? $database : "will");
    // $database = database($database, $connect);
	// $database 	= (isset($database) 	? $database 	: "");

	$mysqli = new mysqli($address, $username, $password, $database);


	switch($mode) {
		case "all":
			$query = 'SELECT id, created, title, blurb, image FROM posts ORDER BY created DESC';
			echo json_query($mysqli, $query);
		break;
		default:
			$mode = (int)$mode;
			if (is_int($mode)) {
				$query = "SELECT id, created, modified, title, blurb, content, image FROM posts WHERE id = $mode";
				echo json_encode(get_query($mysqli, $query)[0][0]);
			}
		break;
	}




	mysqli_close($mysqli);
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
