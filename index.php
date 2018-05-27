<?php
	
	// увімкнення буферизації введення
	ob_start();

	// підключаємо файл із HTML-розміткою
	include 'first.php';

	// підключаємося до БД
	// $mysqli = new mysqli("localhost", "hworknet_admin", "11223344", "hworknet_test");
	$mysqli = new mysqli("localhost", "mysql", "mysql", "hworknet_test");
	$mysqli -> query("SET NAMES 'utf8'");
	
	// якщо натиснута кнопка відправити, то отримуємо дані із input'ів в змінні
	if (isset($_REQUEST['send'])) {
	$input_nickname = $_REQUEST['input_nickname'];
	$input_text = $_REQUEST['input_text'];

	// перетворюємо спеціальні символи в HTML-сутності
	$input_nickname = htmlspecialchars($input_nickname);
	$input_text = htmlspecialchars($input_text);

	// визначаємо дату і час додавання коментаря
	$time = date('H:i', strtotime("+0 hours"));
	$date = date('d.m.Y');
	$datetime = $date.", ".$time;

	// виконуємо запит до БД, додаємо потрібні дані в потрібні поля
	if (!empty($input_nickname) && !empty($input_text)){
		$success = $mysqli -> query ("INSERT INTO `comments` (`nickname`, `text`, `datetime`) VALUES ('$input_nickname', '$input_text', '$datetime') 	");
		// header("Location: http://hwork.net/guestbook/");
		header("Location: http://localhost/guestbook/");
		}
	}

	// якщо натиснута кнопка Видалити
	if (isset($_REQUEST['delete'])) {
		// видаляються всі записи (записи, які ідуть після 1)
		$mysqli -> query ("DELETE FROM `hworknet_test`.`comments` WHERE `comments`.`id` >= 0");

		// анулюєм значення інкремента
		$mysqli -> query ("ALTER TABLE comments AUTO_INCREMENT = 0");
		// header("Location: http://hwork.net/guestbook/");
		header("Location: http://localhost/guestbook/");
	}

	// отримуємо дані із БД
	$result = $mysqli -> query("SELECT * FROM `comments` ORDER BY `id` DESC");

	// якщо натиснута кнопка Старі повідомлення зверху, то сортуємо по зростанню id
	if (isset($_REQUEST['asc'])) {
		$result = $mysqli -> query("SELECT * FROM `comments` ORDER BY `id` ASC");
	}

	// якщо натиснута кнопка Нові повідомлення зверху, то сортуємо по спаданню id
	if (isset($_REQUEST['desc'])) {
		$result = $mysqli -> query("SELECT * FROM `comments` ORDER BY `id` DESC");
	}

	// отримуємо записи із результуючого набору і поміщаємо їх в асоціативний масив
	$comment = mysqli_fetch_array($result);
	
					// виведення всіх коментарів
					
					// do{
					// 	if ($comment != ""){
					// 		echo " 
					// 		<div class='panel panel-default'>
					// 		<div class='panel-heading'>
					// 		".$comment['nickname'].", ".$comment['datetime']."
					// 		</div>
					// 		<div class='panel-body'>
					// 		".$comment['text']."
					// 		</div>
					// 		</div>
					// 		";
					// 	} else {
					// 		echo " 
					// 		<div class='panel panel-default'>
					// 		<div class='panel-heading'>
					// 		Тут пусто!
					// 		</div>
					// 		<div class='panel-body'>
					// 		Поки що ніхто нічого не написав.
					// 		</div>
					// 		</div>
					// 		";
					// 	}
					// } while ($comment = mysqli_fetch_array($result));

	do{
		if ($comment != "" && $nick == $comment['nickname']){
			echo " 
			<div class='panel panel-default'>
			<div class='panel-heading'>
			".$comment['nickname'].", ".$comment['datetime']." 
		
			<div class='forms'>
			<form method='POST' class='form'>
				<button class='btn btn-danger' type='submit' name='del' value='".$comment['id']."'><i class='fa fa-trash-o' aria-hidden='true'></i></button>
			</form>
			<form method='POST' class='form'>
				<button class='btn btn-primary' type='submit' name='edit' value='".$comment['id']."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>
			</form>
			</div>
			</div>
			<div class='panel-body'>
			".$comment['text']."
			</div>
			</div>
			";
		} else if ($comment != "" && $nick != $comment['nickname']){
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

	// видалення будь-якого коментаря
	if (isset($_REQUEST['del'])) {
		$val_del = $_POST['del'];
		$mysqli -> query ("DELETE FROM `hworknet_test`.`comments` WHERE `comments`.`id` = $val_del");
		header("Location: http://localhost/guestbook/");
	}

	// редагування будь-якого коментаря
	if (isset($_REQUEST['edit'])) {
		$val_edit = $_POST['edit'];
		session_start();
  		$_SESSION["edit"] = $val_edit; 
  		header("Location: http://localhost/guestbook/edit.php");

	}

	// підключення файлу із HTML-розміткою
	include'second.html';

	// відправляємо буфер виведення, очищаємо і відключаємо
	ob_flush();
?>