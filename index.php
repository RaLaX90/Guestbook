<?php
	ob_start();
	include 'first.html';
	$mysqli = new mysqli("localhost", "hworknet_admin", "11223344", "hworknet_test");
	$mysqli -> query("SET NAMES 'utf8'");
	
	if (isset($_REQUEST['send'])) {
	$input_nickname = $_REQUEST['input_nickname'];
	$input_nickname = htmlspecialchars($input_nickname);
	$input_text = $_REQUEST['input_text'];
	$input_text = htmlspecialchars($input_text);
	$time = date('H:i', strtotime("+2 hours"));
	$date = date('d.m.Y');
	$datetime = $date.", ".$time;
	$success = $mysqli -> query ("INSERT INTO `comments` (`nickname`, `text`, `datetime`) VALUES ('$input_nickname', '$input_text', '$datetime') 	");
	header("Location: http://hwork.net/guestbook/");
	}

	if (isset($_REQUEST['delete'])) {
		$mysqli -> query ("DELETE FROM `hworknet_test`.`comments` WHERE `comments`.`id` >= 0");
		$mysqli -> query ("ALTER TABLE comments AUTO_INCREMENT = 0");
		header("Location: http://hwork.net/guestbook/");
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