<?php

require_once "functions.php";

function getTotalSPBandwidth() {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT SUM(downlinkmax) FROM (SELECT MAX(downlink) as downlinkmax, userid FROM `testrun` where role = '1' GROUP BY userid) as tt";
	$result = $mysqli->query($sql);
	$down = $result->fetch_row();
	
	$sql = "SELECT SUM(uplinkmax) FROM (SELECT MAX(uplink) as uplinkmax, userid FROM `testrun` where role = '1' GROUP BY userid) as tt";
	$result = $mysqli->query($sql);
	$up = $result->fetch_row();
	
	$mysqli->close();
	return ($down[0] / 1024 / 1024)." Mbps Down ".($up[0] / 1024 / 1024)." Mbps Up";
}

function getTotalSPs() {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT COUNT(DISTINCT userid) FROM testrun WHERE role = '1'";
	$result = $mysqli->query($sql);
	$count = $result->fetch_row();
	$mysqli->close();
	return $count[0];
}

function getTotalDSs() {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT COUNT(DISTINCT userid) FROM testrun WHERE role = '2'";
	$result = $mysqli->query($sql);
	$count = $result->fetch_row();
	$mysqli->close();
	return $count[0];
}

function getTotalBNs() {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT COUNT(DISTINCT userid) FROM testrun WHERE role = '3'";
	$result = $mysqli->query($sql);
	$count = $result->fetch_row();
	$mysqli->close();
	return $count[0];
}

function getTotalDSBandwidth() {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT SUM(downlinkmax) FROM (SELECT MAX(downlink) as downlinkmax, userid FROM `testrun` where role = '2' GROUP BY userid) as tt";
	$result = $mysqli->query($sql);
	$down = $result->fetch_row();
	
	$sql = "SELECT SUM(uplinkmax) FROM (SELECT MAX(uplink) as uplinkmax, userid FROM `testrun` where role = '2' GROUP BY userid) as tt";
	$result = $mysqli->query($sql);
	$up = $result->fetch_row();
	
	$mysqli->close();
	return ($down[0] / 1024 / 1024)." Mbps Down ".($up[0] / 1024 / 1024)." Mbps Up";
}

function getTotalNodes() {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT COUNT(*) FROM users";
	$result = $mysqli->query($sql);
	$count = $result->fetch_row();
	$mysqli->close();
	return $count[0];
}

function getNodes() {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return;
	}
	$sql = "SELECT * FROM users";
	$result = $mysqli->query($sql);
	if($result !== false && $result->num_rows == 0) {
		$mysqli->close();
		return;
	}
	while($row = $result->fetch_row()) {
		echo "{
		ip: '$row[1]',
		radius: 5,
		fillKey: 'SP',
		latitude: $row[3],
		longitude: $row[2]
		},";
	}
	
	$mysqli->close();
}

?>

<html>
<head>
<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/topojson/1.6.9/topojson.min.js"></script>
<script src="/datamaps.all.min.js"></script>
</head>
<body>
	<strong>SP BW</strong>: <?php echo getTotalSPBandwidth(); ?>  <strong>DS BW</strong>: <?php echo getTotalDSBandwidth(); ?>  <br/>
	<strong>Total SPs</strong>: <?php echo getTotalSPs(); ?>   <strong>Total DSs</strong>: <?php echo getTotalDSs(); ?>   <strong>Total BNs</strong>: <?php echo getTotalBNs(); ?> <br/>
	<strong>Total Nodes: </strong>: <?php echo getTotalNodes(); ?>
	<center><div id="container" style="position: relative; width: 1800px; height: 900px;"></div></center>
	<script>
    var map = new Datamap({
		element: document.getElementById("container"),
		geographyConfig: {
			popupOnHover: false,
			highlightOnHover: false
		},
		fills: {
			defaultFill: '#333',
			DS: 'blue',
			SP: 'green',
			BN: 'red'
		}
	});
	
	map.bubbles([ 
	<?php getNodes(); ?>
	], {
		popupTemplate: function(geo, data) { 
			return '<div class="hoverinfo">IP:' + data.ip + ' longitude ' + data.longitude + ' latitude '  + data.latitude + ''
	}});
	</script>
</body>
</html>
