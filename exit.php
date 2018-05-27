<?php
	// вихід з акаунта

	// увімкнення буферизації введення
	ob_start();

	// з'єднання з БД
	$link = new mysqli("localhost", "hworknet_admin", "11223344", "hworknet_test");
	// $link = new mysqli("localhost", "mysql", "mysql", "hworknet_test");
	
	$query = $link -> query("SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
	$data = mysqli_fetch_assoc($query);

	setcookie("id","");
	setcookie("hash", "");

	header("Location: index.php"); 
	exit();

	// відправляємо буфер виведення, очищаємо і відключаємо
	ob_flush();
?>