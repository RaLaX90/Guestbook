<?php

	// увімкнення буферизації введення
	ob_start();

    // з'єднання з БД
    include 'connect.php';

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
        $query = $mysqli -> query("SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        // перевірка на логін користувача
        if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])){
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
            $nick = 'Акаунт';
            $add  = '
				<li><a href="login.php">Вхід</a></li>
				<li><a href="register.php">Реєстрація</a></li>
            ';
            header("Location: index.php");
        } else{
            $nick = $userdata['user_login'];
            $add  = '
				<li><a href="exit.php">Вихід</a></li>
            ';
            $style = 'style = "display: none;"';
            
            if ($nick == "admin"){
            	$admin_button = '<hr> <button type="submit" class="btn btn-danger" name="delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Видалити всі</button>';
            }
        }
    } else{
        $nick = 'Акаунт';
        $add  = '
			<li><a href="login.php">Вхід</a></li>
			<li><a href="register.php">Реєстрація</a></li>
        ';
        header("Location: index.php");
    }

    // визначаємо дату і час редагування коментаря
	$time = date('H:i', strtotime("+0 hours"));
	$date = date('d.m.Y');
	$datetime = $date.", ".$time;

    // передача даних (id) коментаря, якого треба відредагувати
	session_start();
  	if (!empty($_SESSION["edit"])){
		$edit = $_SESSION["edit"]; 
	} else {
		//echo "Error";
		header("Location: index.php");
	}
	
	// отримати текст коментаря, який треба відредагувати
	$query = $mysqli -> query("SELECT `text` FROM `comments` WHERE id = ".$edit."");
	$array = mysqli_fetch_array($query);
	$message = $array[0];

	// редагування вибраного коментаря
	$input_text = $_REQUEST['input_text'];
	if (isset($_REQUEST['edit']) && !empty($input_text)) {
		$query = $mysqli -> query("UPDATE `hworknet_test`.`comments` SET `text` = '".$input_text."', `datetime` = '".$datetime."' WHERE `comments`.`id` = ".$edit.";");
		echo "<script> alert('".$edit."'); </script>";
		header("Location: edit.php");
	}
?>
<!DOCTYPE html>
<html>
	<head> 
		<title> Гостьова книга </title>
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
				<a class="navbar-brand" href="http://hwork.net/guestbook/">Гостьова книга</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Головна</a></li>
					<li class="active"><a href="edit.php">Редагування коментаря</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_about">Про автора</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_contact">Контакти</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_admin">Перегляд</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $nick; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php echo $add; ?>
						</ul>
					</li>

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
					Автор цієї сторінки — Богдан Щербаков, який навчається в групі ПС-46. <br> Створено спеціально для базового керівництва по створенню сайтів.
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
					<h4 class="modal-title" id="myModalLabel">Перегляд</h4>
				</div>
				<div class="modal-body">
					<form method="POST">
						<button type="submit" class="btn btn-info" name="asc"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i></button> Старі повідомлення зверху <br> <br>
						<button type="submit" class="btn btn-info" name="desc"><i class="fa fa-sort-numeric-desc" aria-hidden="true"></i></button> Нові повідомлення зверху</i>
						<?php echo $admin_button; ?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="all">
		<h1><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редагувати коментар</h1>
		<br>
		<form method="POST">
			<div class="form-group">
				<label for="inputName" <?php echo $style; ?>>Ім'я або нікнейм</label>
				<input <?php echo $style; ?> required class="form-control" type="text" id="inputName" placeholder="Петро Іванов" name="input_nickname" value="<?php echo $nick; ?>">
			</div>
			<div class="form-group">
				<label for="inputComment">Текст коментаря:</label>
				<textarea required class="form-control" rows="5" id="inputComment" placeholder="Будь-який текст коментаря." name="input_text"><?php echo $message; ?></textarea>
			</div>
			<button type="submit" class="btn btn-success" name="edit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Зберегти</button>
		</form>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>
<?php 
	// відправляємо буфер виведення, очищаємо і відключаємо
	ob_flush();
?>