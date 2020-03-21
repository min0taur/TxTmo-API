<?php
// include the class
include 'TxTmo.php';

// send SMS
$result = '';
if( $_POST ) {
	$sms = new TxTmo();
	$sms->to = $_POST['phone'];
	$sms->message = $_POST['message'];
	$result = json_decode($sms->_send(),true);
	if( $result['status'] == 'error' ) {
		$result = 'Error: '.$result['message'];
	} else {
		//$result = $result['message'].' Message ID: '.$result['id'];
		die(header('Location: ?id='.$result['id']));
	}
}

// check Status
if( isset($_GET['id']) ) {
	$sms = new TxTmo();
	$sms->id = $_GET['id'];
	$result = json_decode($sms->_status(),true);
	if( $result['status'] == 'error' ) {
		$result = 'Error: '.$result['message'];
	} else {
		// add refresh button pag pending pa
		$ref = '';
		if( $result['message'] == 'Pending' ) $ref = ' <a href="'.$_SERVER['PHP_SELF'].'?id='.$_GET['id'].'">refresh</a>';
		$result = 'Message Status: '.$result['message'].$ref;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>TxTmo SMS API</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
<div>
<?php echo $result; ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Phone Number:<br>
<input type="number" name="phone"/><br>
Message:<br>
<textarea name="message"></textarea><br>
<input type="submit" value="Send SMS"/>
</form>
</div>
</body>
</html>