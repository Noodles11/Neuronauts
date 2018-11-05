<?php

if( isset($_GET['md5']) ){
	print_r($_GET['md5']);
	echo '</br>';
	print_r(md5($_GET['md5']));
}

else if( isset($_GET['mail']) ){
	print_r($_GET['mail']);
	echo '</br>';
	$mail=$_GET['mail'];
	preg_match('/[a-zA-Z0-9]+[@]{1}[a-zA-Z0-9]+[.]{1}[a-zA-Z]+/', $mail, $result, PREG_OFFSET_CAPTURE);
	print_r($result);
}

else {
	session_start();
	print_r($_SESSION);
}

?>
