<?php
	ob_start();
	$link = mysqli_connect("localhost", "mysql", "mysql", "hworknet_test");
	$query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
	$data = mysqli_fetch_assoc($query);

	setcookie("id","");
	setcookie("hash", "");

	header("Location: index.php"); exit();
	ob_flush();
?>