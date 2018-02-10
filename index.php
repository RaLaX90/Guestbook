<?php ob_start(); ?>
<!DOCTYPE html>
<html>
	<head> 
		<title> Test </title>
		<link rel="stylesheet" href="style.css">
		<link rel="shortcut icon" href="ico.ico" type="image/x-icon">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://use.fontawesome.com/6854e2086f.js"></script>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Гостьова книга</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="#" data-toggle="modal" data-target="#myModal_about">Про автора</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_contact">Контакти</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_admin">Адміністрування</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="modal fade" id="myModal_about" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Про автора</h4>
				</div>
				<div class="modal-body">
					Автор цієї сторінки — Богдан Щербаков, який навчається в групі ПС-46. <br> Створено спеціально для О.О.
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Контакти</h4>
				</div>
				<div class="modal-body">
					<a href="https://t.me/gmastrbit" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i> Telegram</a> <br>
					<a href="https://vk.com/gmastrbit" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i> VK</a> <br>
					<a href="https://www.facebook.com/gmastrbit" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</a> <br>
					<a href="https://www.behance.net/gmastrbit" target="_blank"><i class="fa fa-behance" aria-hidden="true"></i> Behance</a> <br>
					<a href="mailto:gmastrbit@gmail.com" target="_blank"> <i class="fa fa-envelope" aria-hidden="true"></i> email</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Адміністрування</h4>
				</div>
				<div class="modal-body">
					<form method="POST">
						<button type="submit" class="btn btn-info" name="asc"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i></button> Старі повідомлення зверху <br> <br>
						<button type="submit" class="btn btn-info" name="desc"><i class="fa fa-sort-numeric-desc" aria-hidden="true"></i></button> Нові повідомлення зверху</i>
						<hr>
						<button type="submit" class="btn btn-danger" name="delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Видалити всі</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="all">
		<h1><i class="fa fa-comments" aria-hidden="true"></i> Залиште коментар</h1>
		<br>
		<form method="POST">
			<div class="form-group">
				<label for="inputName">Ім'я або нікнейм</label>
				<input class="form-control" type="text" id="inputName" placeholder="Петро Іванов" name="input_nickname">
			</div>
			<div class="form-group">
				<label for="inputComment">Текст коментаря:</label>
				<textarea class="form-control" rows="5" id="inputComment" placeholder="Прекрасний приклад використання фреймворку Bootstrap для власних цілей." name="input_text"></textarea>
			</div>
			<button type="submit" class="btn btn-primary" name="send"><i class="fa fa-paper-plane" aria-hidden="true"></i> Надіслати</button>
		</form>
		<br>
		<h1><i class="fa fa-eye" aria-hidden="true"></i> Перегляд всіх коментарів</h1>
		<br>
		<?php
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
		?>
<!-- 		<div class="panel panel-default">
			<div class="panel-heading">
				Петро Сагайдачний, 15.02.2018, 17:36
			</div>
			<div class="panel-body">
				Дуже класний сайт! Рекомендую.
			</div>
		</div> -->
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>
<?php ob_flush(); ?>