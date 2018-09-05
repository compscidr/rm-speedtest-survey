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

function getTotalBNBandwidth() {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT SUM(downlinkmax) FROM (SELECT MAX(downlink) as downlinkmax, userid FROM `testrun` where role = '3' GROUP BY userid) as tt";
	$result = $mysqli->query($sql);
	$down = $result->fetch_row();
	
	$sql = "SELECT SUM(uplinkmax) FROM (SELECT MAX(uplink) as uplinkmax, userid FROM `testrun` where role = '3' GROUP BY userid) as tt";
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

function getRole($id) {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT DISTINCT(role) FROM testrun WHERE userid = '$id'";
	$result = $mysqli->query($sql);
	
	$roles = "";
	while($role = $result->fetch_row()) {
		$roles = $roles . $role[0] . ",";
	}
	
	$mysqli->close();
	return $roles;
}

function getUplink($id) {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT MAX(uplink) FROM testrun WHERE userid = '$id'";
	$result = $mysqli->query($sql);
	
	
	$uplink = $result->fetch_row();
	$mysqli->close();
	return ($uplink[0] / 1024 / 1024)." Mbps";
}

function getDownlink($id) {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT MAX(downlink) FROM testrun WHERE userid = '$id'";
	$result = $mysqli->query($sql);
	
	
	$downlink = $result->fetch_row();
	$mysqli->close();
	return ($downlink[0] / 1024 / 1024)." Mbps";
}

function getRTT($id) {
	$mysqli = attemptConnect();
	if($mysqli->connect_error){
		return 0;
	}
	$sql = "SELECT MIN(rtt) FROM testrun WHERE userid = '$id'";
	$result = $mysqli->query($sql);
	
	
	$rtt = $result->fetch_row();
	$mysqli->close();
	return $rtt[0]." ms";
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
	echo "var locations = [";
	while($row = $result->fetch_row()) {
		$role = getRole($row[0]);
		$uplink = getUplink($row[0]);
		$downlink = getDownlink($row[0]);
		$rtt = getRTT($row[0]);
		echo "{lat: $row[3], lng: $row[2], ip: '$row[1]', role: '$role', uplink: '$uplink', downlink: '$downlink', rtt: '$rtt'},";
	}
	echo "]";
	
	$mysqli->close();
}

?>

<html>
<head>
<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/topojson/1.6.9/topojson.min.js"></script>
<script src="/datamaps.all.min.js"></script>
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
</head>
<body>
	<strong>SP BW</strong>: <?php echo getTotalSPBandwidth(); ?>  <strong>DS BW</strong>: <?php echo getTotalDSBandwidth(); ?>  <strong>BN BW</strong>: <?php echo getTotalBNBandwidth(); ?><br/>
	<strong>Total SPs</strong>: <?php echo getTotalSPs(); ?>   <strong>Total DSs</strong>: <?php echo getTotalDSs(); ?>   <strong>Total BNs</strong>: <?php echo getTotalBNs(); ?> <br/>
	<strong>Total Nodes: </strong>: <?php echo getTotalNodes(); ?>
	<div id="map"></div>
	<script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 35.3305258, lng: -101.8565776},
          zoom: 3
        });
        
        // Create an array of alphabetical characters used to label the markers.
        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
			marker = new google.maps.Marker({
				position: location
			});
			
			if(location.role == '1,') {
				marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
				marker.setLabel("SP");
			} else if(location.role == '2,') {
				marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
				marker.setLabel("DS");
			} else if(location.role == '3,') {
				marker.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');
				marker.setLabel("BN");
			} else if((location.role == '1,2,') || (location.role == '2,1,')) {
				marker.setIcon('http://maps.google.com/mapfiles/ms/icons/yellow-dot.png');
				marker.setLabel("SP & DS");
			} else if((location.role == '1,3,') || (location.role == '3,1,')){
				marker.setIcon('http://maps.google.com/mapfiles/ms/icons/orange-dot.png');
				marker.setLabel("SP & BN");
			} else if((location.role == '2,3,') || (location.role == '3,2,')){
				marker.setIcon('http://maps.google.com/mapfiles/ms/icons/purple-dot.png');
				marker.setLabel("DS & BN");
			} else {
				marker.setIcon('http://maps.google.com/mapfiles/ms/icons/pink-dot.png');
				marker.setLabel("SP & DS & BN");
			}
			
			infowindow = new google.maps.InfoWindow();
			content = location.ip + "<br/>Up: " + location.uplink + " Down: " + location.downlink + " RTT: " + location.rtt;
			google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
				return function() {
					infowindow.setContent(content);
					infowindow.open(map,marker);
			};
			})(marker,content,infowindow)); 
			
			return marker;
        });
        
        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      
      }
      
      <?php echo getNodes(); ?>
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB83wyhovk3qMQaXrjMFYRFXBAkNTQp75E&callback=initMap"
    async defer></script>
</body>
</html>
