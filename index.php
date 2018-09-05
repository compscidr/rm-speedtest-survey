<html>
<head>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="JQSpeedTest.js"></script>
	<script>
		Demo1 = new JQSpeedTest({
		testStateCallback: Demo1callBackFunctionState,
		testFinishCallback: Demo1callbackFunctionFinish,
		testDlCallback: Demo1callbackFunctionDl,
		testUlCallback: Demo1callbackFunctionUl,
		testReCallback: Demo1callbackFunctionRe,
	});
	
	/** Demo1 Sample Call Back Function for State **/
	function Demo1callBackFunctionState(value){
		$('#state').text(value);
		if(value == "stopped") {
			$('#submit').prop('disabled', false);
		}
	}
	/** Demo1 Sample Call Back Function for Finshi **/
	function Demo1callbackFunctionFinish(value){
		//$('#Demo-1-StartButton').show();
		//$('#Demo-1-StopButton').hide();
	}
	/** Demo1 Sample Call Back Function for Download Result **/
	function Demo1callbackFunctionDl(value, duration){
		$('#dlstatus').text("dl " + value + " " + duration + "s");
		$("#downlink").val(value);
	}
	/** Demo1 Sample Call Back Function for Upload Result **/
	function Demo1callbackFunctionUl(value, duration){
		$('#ulstatus').text("ul " + value + " " + duration + "s");
		$("#uplink").val(value);
	}
	/** Demo1 Sample Call Back Function for Response Time **/
	function Demo1callbackFunctionRe(value, duration){
		$('#rttstatus').text("rtt " + value + " " + duration + "ms");
		$("#rtt").val(value);
	}
	</script>
</head>
<body>
<h1>Survey</h1>
<form action="test.php" method="POST">
	<select name="role">
		<option value="sp">Superpeer</option>
		<option value="ds">Data Seller</option>
		<option value="bn">End User</option>
	</select>
	<input type="hidden" name="uplink" id="uplink" value="0"/>
	<input type="hidden" name="downlink" id="downlink" value="0"/>
	<input type="hidden" name="rtt" id="rtt" value="0"/>
	<input type="submit" id="submit" disabled/>
</form>
<div id="dlstatus"></div>
<div id="ulstatus"></div>
<div id="rttstatus"></div>
<div id="state"></div>
</body>
</html>
