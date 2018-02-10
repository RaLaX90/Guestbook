<?php
	ob_start();
	include 'first.html';
	$mysqli = new mysqli("localhost", "root", "", "guestbook");
	$mysqli -> query("SET NAMES 'utf8'");
	// if ($mysqli -> connect_errno) {
	// 	   	printf("Connection error.: %s\n", $mysqli->connect_error);
	// 	   	exit();
	// 	} else {
	// 		echo "Connection nice.";
	// 	}
	
	if (isset($_REQUEST['send'])) {
	$input_nickname = $_REQUEST['input_nickname'];
	$input_text = $_REQUEST['input_text'];
	$time = date('H:i', strtotime("-1 hours"));
	$date = date('d.m.Y');
	$datetime = $date.", ".$time;
	$success = $mysqli -> query ("INSERT INTO `comments` (`nickname`, `text`, `datetime`) VALUES ('$input_nickname', '$input_text', '$datetime') 	");
	header("Location: http://localhost/guestbook/index.php");
	}

	if (isset($_REQUEST['delete'])) {
		$mysqli -> query ("DELETE FROM `guestbook`.`comments` WHERE `comments`.`id` >= 0");
		header("Location: http://localhost/guestbook/index.php");
	}

	$result = $mysqli -> query("SELECT * FROM `comments` ORDER BY `id` DESC");

	if (isset($_REQUEST['asc'])) {
		$result = $mysqli -> query("SELECT * FROM `comments` ORDER BY `id` ASC");
	}

	if (isset($_REQUEST['desc'])) {
		$result = $mysqli -> query("SELECT * FROM `comments` ORDER BY `id` DESC");
	}

	$comment = mysqli_fetch_array($result);

	do{
		if ($comment != ""){
			echo " 
			<div class='panel panel-default'>
			<div class='panel-heading'>
			".$comment['nickname'].", ".$comment['datetime']."
			</div>
			<div class='panel-body'>
			".$comment['text']."
			</div>
			</div>
			";
		} else {
			echo " 
			<div class='panel panel-default'>
			<div class='panel-heading'>
			Тут пусто!
			</div>
			<div class='panel-body'>
			Поки що ніхто нічого не написав.
			</div>
			</div>
			";
		}
	} while ($comment = mysqli_fetch_array($result));
	include'second.html';
	ob_flush();
?>