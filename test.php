<?php

if(!isset($_POST["uplink"]) || !isset($_POST["downlink"]) || !isset($_POST["rtt"]) || !isset($_POST["role"])) {
	exit;
}

$uplink = $_POST["uplink"];
$downlink = $_POST["downlink"];
$rtt = $_POST["rtt"];
$role = $_POST["role"];

//convert the string into the ints in the db
if($role == "sp") {
	$role = 1;
} else if ($role == "ds") {
	$role = 2;
} else {
	$role = 3;
}

require_once "functions.php";

class IP {
	public $id;
	public $longitude;
	public $latitude;
}

/**
 * Returns the longitude and latitude given the IP address
 */
function getGPSFromIP($ip) {
	$url = "http://api.ipstack.com/$ip?access_key=d038eb9e79d82b2fde5939a69f32c2db&format=1";
	$ch = curl_init( $url );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	$ip = new IP();
	if(!$result) {
		echo 'Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl);
		$ip->longitude = 0;
		$ip->latitude = 0;
	} else {
		$obj = json_decode($result);
		$ip->longitude = $obj->{'longitude'};
		$ip->latitude = $obj->{'latitude'};
	}
	curl_close($ch);
	return $ip;
}

function getUserID($ip) {
  $mysqli = attemptConnect();
  if($mysqli->connect_error){
    return;
  }
  
  $sql = "SELECT * FROM users WHERE ip = '$ip'";
  $result = $mysqli->query($sql);
  if($result !== false && $result->num_rows == 0) {
    //echo "Error: couldn't find user in the database";
    $mysqli->close();
    return;
  }
  
  $row = $result->fetch_row();

  $ip = new IP();
  $ip->id = $row[0];
  $ip->ip = $row[1];
  $ip->longitude = $row[2];
  $ip->latitude = $row[3];
  
  $mysqli->close();
  
  return $ip;
}

function updateUser($uplink, $downlink, $rtt, $role) {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	$id = getUserID($ip);
	if(!$id) {
		$gps = getGPSFromIP($ip);
		$sql = "INSERT into `users` (`ip`, `longitude`, `latitude`) VALUES ('$ip','$gps->longitude','$gps->latitude')";
		$mysqli->real_query($sql);
		$gps = getUserID($ip); //this is dumb but im too lazy to figure out the mysql command to get the id we just inserted///todo fix
	} else {
		$gps = $id;
	}
	//echo "$gps->longitude <br/> $gps->latitude";
	
	$sql = "INSERT into `testrun` (`userid`, `uplink`, `downlink`, `rtt`, `role`) VALUES('$gps->id', '$uplink', '$downlink', '$rtt', '$role')";
	echo $sql;
	$mysqli->real_query($sql);
    $mysqli->close();
}

updateUser($uplink, $downlink, $rtt, $role);
header("Location: http://97.107.187.42/maps.php");
die();
?>
